<?php

namespace App\Http\Tenant\Collection\Repository;

use App\Http\Tenant\Collection\Models\Collection;
use App\Http\Tenant\Invoice\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionRepository {

    const CollectionGracePeriod = 14;

    /**
     * @var Bill
     */
    private $bill;
    /**
     * @var Collection
     */
    private $collection;
    /**
     * @var Request
     */
    private $request;

    function __construct(Request $request, Bill $bill, Collection $collection)
    {

        $this->bill = $bill;
        $this->collection = $collection;
        $this->request = $request;
    }

    function billsWaitingCollection()
    {
        $select = ['b.id', 'c.name as customer_name', 'b.invoice_number', 'b.total', 'b.paid', 'b.remaining', DB::raw('DATE_FORMAT(b.due_date,"%Y-%m-%d") as due_date')];

        $take = ($this->request->input('length') > 0) ? $this->request->input('length') : 15;
        $start = ($this->request->input('start') > 0) ? $this->request->input('start') : 0;

        $search = $this->request->input('search');
        $search = $search['value'];
        $order = $this->request->input('order');
        $column_id = $order[0]['column'];
        $columns = $this->request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $bill = array();

        $query = $this->bill->select($select)->from('fb_bill as b')
            ->leftJoin('fb_customers as c', 'c.id', '=', 'b.customer_id')
            ->where(DB::raw('DATE_ADD(b.due_date,INTERVAL 14 DAY)'), '<', date('Y-m-d'))// get overdue bill
            ->where('b.status', 0)// get only unpaid bill
            ->where('b.is_offer', 0); // get only bill type


        if ($orderColumn != '' AND $orderdir != '') {
            $orderColumn = ($orderColumn == 'customer_name') ? 'c.name' : 'b.' . $orderColumn;
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        if ($search != '') {
            $query = $query->where('c.name', 'LIKE', "%$search%");
        }
        $bill['total'] = $query->count();


        $query->skip($start)->take($take);

        $bill['data'] = $query->get()->toArray();

        $json = new \stdClass();
        $json->draw = ($this->request->input('draw') > 0) ? $this->request->input('draw') : 1;
        $json->recordsTotal = $bill['total'];
        $json->recordsFiltered = $bill['total'];
        $json->data = $bill['data'];

        return $json;
    }


    function convertToCurrency($num)
    {
        return '$' . number_format($num, 2);
    }


    function makeCase($id)
    {
        $bill = $this->bill->find($id);
        if ($bill) {
            $bill->status = BILL::STATUS_COLLECTION;
            $bill->save();

            return true;
        }

        return false;
    }


    function billsOnCollection()
    {

    }

} 