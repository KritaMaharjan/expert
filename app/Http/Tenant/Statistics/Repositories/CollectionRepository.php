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

}
