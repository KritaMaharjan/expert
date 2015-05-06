<?php

namespace App\Http\Tenant\Collection\Repositories;

use App\Fastbooks\Libraries\Pdf;
use App\Http\Tenant\Accounting\Libraries\Record;
use App\Http\Tenant\Collection\Models\Collection;
use App\Http\Tenant\Invoice\Models\Bill;
use App\Models\Tenant\Customer;
use App\Models\Tenant\Setting;
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
    /**
     * @var Setting
     */
    private $setting;

    function __construct(Request $request, Bill $bill, Collection $collection, Setting $setting)
    {
        $this->bill = $bill;
        $this->collection = $collection;
        $this->request = $request;
        $this->setting = $setting;
    }

    /**
     * @return \stdClass
     */
    function billsWaitingCollection()
    {
        $status = [BILL::STATUS_UNPAID, BILL::STATUS_PARTIAL_PAID];
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
            ->whereIn('b.status', $status)// get bills having collection status
            ->where('b.payment', '!=', BILL::STATUS_PAID)// get only unpaid bill
            ->where('b.status', '=', BILL::STATUS_ACTIVE)// get only unpaid bill
            ->where('b.is_offer', BILL::TYPE_BILL); // get only bill type

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


    /**
     * @internal param array $status
     * @internal param array $select
     * @return \stdClass
     */
    public function billsOnCollection()
    {
        $status = [BILL::STATUS_COLLECTION];
        $select = [DB::raw('MAX(col.step) as step'), DB::raw('MAX(col.created_at) as created_at'), 'b.id', 'c.name as customer_name', 'b.invoice_number', 'b.total as bill_total', 'b.paid', 'b.remaining', DB::raw('DATE_FORMAT(b.due_date,"%Y-%m-%d") as due_date')];

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

        $step = $this->request->get('step');
        $step_string = $step == '' ? 'purring' : $step;
        $step = Collection::getStep($step_string);

        $query = $this->bill->select($select)->from('fb_bill as b')
            ->leftJoin('fb_customers as c', 'c.id', '=', 'b.customer_id')
            ->leftJoin('fb_collection as col', 'col.bill_id', '=', 'b.id')
            ->whereIn('b.status', $status)// get bills having collection status
            ->where('b.payment', '!=', BILL::STATUS_PAID)// get only unpaid bill
            ->where('b.is_offer', BILL::TYPE_BILL)// get only bill type
            ->groupBy('b.id')
            ->having('step', '=', $step);
        if ($orderColumn != '' AND $orderdir != '') {

            switch ($orderColumn) {
                case 'customer_name':
                    $orderColumn = 'c.name';
                    break;

                case 'bill_total':
                    $orderColumn = 'b.total';
                    break;

                default:
                    $orderColumn = 'b.' . $orderColumn;
                    break;
            }

            $query = $query->orderBy($orderColumn, $orderdir);
        }

        if ($search != '') {
            $query = $query->where('c.name', 'LIKE', "%$search%");
        }
        $bill['total'] = count($query->get());


        $query->skip($start)->take($take);

        $bill_data = $query->get()->toArray();
        $nextStep = Collection::nextStep($step_string);
        $fee = Collection::fee($step_string);
        foreach ($bill_data as &$bill_value) {
            $bill_value['isGoToStep'] = Collection::isGoToStep($bill_value['created_at']);
            $bill_value['goToStep'] = $nextStep;
            $bill_value['interest'] = $interest = Collection::interest($bill_value['due_date'], $bill_value['bill_total']);
            $bill_value['fee'] = $fee;
            $bill_value['step'] = $step_string;
            $bill_value['remaining'] += ($fee + $interest);
            $bill_value['deadline'] = Collection::deadline($bill_value['created_at']);;
        }


        $bill['data'] = $bill_data;

        $json = new \stdClass();
        $json->draw = ($this->request->input('draw') > 0) ? $this->request->input('draw') : 1;
        $json->recordsTotal = $bill['total'];
        $json->recordsFiltered = $bill['total'];
        $json->data = $bill['data'];

        return $json;
    }

    /**
     * @param $id
     * @return bool
     */
    function makeCase($id)
    {
        $bill = $this->bill->find($id);
        if ($bill) {
            $bill->status = BILL::STATUS_COLLECTION;
            $bill->save();
            $this->changeCollectionStep($bill->id, 'purring');

            return true;
        }

        return false;
    }


    /**
     * @param $id
     * @return array
     */
    function getBillInfo($id)
    {
        $bill = $this->bill->billDetails($id);
        $company = $this->setting->getCompany();
        $business = $this->setting->getBusiness();
        $fix = $this->setting->getFix();
        $company_details = array_merge($company, $business, $fix);

        $bill_details = array(
            'id'                      => $bill->id,
            'amount'                  => $bill->total,
            'currency'                => $bill->currency,
            'invoice_number'          => $bill->invoice_number,
            'invoice_date'            => $bill->created_at,
            'due_date'                => $bill->due_date,
            'customer'                => $bill->customer,
            'customer_payment_number' => $bill->customer_payment_number,
            'customer_details'        => $bill->customer_details->toArray(),
            'company_details'         => $company_details
        );

        return $bill_details;
    }

    /**
     * @param $bill
     * @param $step
     * @return static
     * @throws \Exception
     */
    function changeCollectionStep($bill, $step)
    {
        $bill = $this->bill->find($bill);
        if ($bill && $this->isValidStep($bill, $step)) {
            $data = [
                'bill_id' => $bill->id,
                'step'    => Collection::getStep($step)
            ];

            return $this->collection->create($data);
        }

        throw new \Exception('Invalid Bill ID');
    }

    /**
     * @param Bill $bill
     * @param $step
     * @return bool
     * @throws \Exception
     */
    public function isValidStep(Bill $bill, $step)
    {
        $collection = $this->collection->where('bill_id', $bill->id)->where('step', Collection::getStep($step))->first();

        if (!empty($collection))
            throw new \Exception('You can\'t change the case status');
        else
            return true;
    }

    function cancelBillCollection($bill)
    {
        $bill = $this->bill->find($bill);
        if ($bill) {
            $bill->status = Bill::STATUS_LOSS;
            $bill->save();
            $customer = Customer::find($bill->customer_id);
            Record::billAsLoss($bill, $customer, $bill->remaining);

            //   $this->collection->where('bill_id', $bill->id)->delete();

            return $bill;
        }

        throw new \Exception('Invalid Bill ID');
    }


    function getAllCollectionPDF($bill)
    {
        $files =[];
        $steps = ['purring', 'inkassovarsel', 'betalingsappfording'];
        foreach($steps as $steps)
        {
           $files[] = $this->generatePDF($bill, $steps, false);
        }

        return $files;
    }

    function generatePDF($bill, $step, $download = true)
    {
        $save = true;
        if ($download) {
            $save = false;
        }
        $data = $this->getBillInfo($bill);
        $pdf = new Pdf();

        return $pdf->generate($data['invoice_number'] . '-' . $step, 'template.collection.' . $step, compact('data'), $download . $save);
    }

}