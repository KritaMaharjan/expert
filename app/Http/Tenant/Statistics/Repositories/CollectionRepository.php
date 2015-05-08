<?php
namespace App\Http\Tenant\Statistics\Repositories;

use App\Http\Tenant\Invoice\Models\Bill;
use Carbon\Carbon;

class CollectionRepository {

    private $from;
    private $to;

    /**
     * @return int
     * Total number of cases
     */
    function getTotalCases() {
        $total = Bill::where('type', 0)->whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return int
     * Total number of bills listed as collection
     */
    function getTotalBills() {
        $total = Bill::where('type', 0)->where('status', 1)->whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return float
     * Total amount in Collection
     */
    function getTotalAmount() {
        $total = Bill::select('total')->where('type', 0)->where('status', 1)->whereBetween('created_at', array($this->from, $this->to))->sum('total');
        return float_format($total);
    }

    /**
     * @return array
     * Statistics for Collection section
     */
    function getCollectionStats($filter = null) {
        if($filter != null) {
            $this->from = $filter['start_date'];
            $this->to = $filter['end_date'];
        } else {
            $this->from = '0000-00-00';
            $this->to = Carbon::now();
        }

        $stats = array();
        $stats['total_bills'] = $this->getTotalBills();
        $stats['total_amount'] = $this->getTotalAmount();
        return $stats;
    }

    function getCasesBySep()
    {

        $status = [BILL::STATUS_COLLECTION];
        $select = [DB::raw('MAX(col.step) as step'), DB::raw('MAX(col.created_at) as created_at'), 'b.id', 'c.name as customer_name', 'b.invoice_number', 'b.total as bill_total', 'b.paid', 'b.remaining', DB::raw('DATE_FORMAT(b.due_date,"%Y-%m-%d") as due_date')];

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
        count($query->get());

    }



}
