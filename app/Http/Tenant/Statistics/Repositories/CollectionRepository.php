<?php
namespace App\Http\Tenant\Statistics\Repositories;

use App\Http\Tenant\Invoice\Models\Bill;

class CollectionRepository {

    /**
     * @return int
     * Total number of cases
     */
    function getTotalCases() {
        $total = Bill::where('type', 0)->count();
        return $total;
    }

    /**
     * @return int
     * Total number of bills listed as collection
     */
    function getTotalBills() {
        $total = Bill::where('type', 0)->where('status', 1)->count();
        return $total;
    }

    /**
     * @return float
     * Total amount in Collection
     */
    function getTotalAmount() {
        $total = Bill::select('total')->where('type', 0)->where('status', 1)->sum('total');
        return float_format($total);
    }

    /**
     * @return array
     * Statistics for Collection section
     */
    function getCollectionStats() {
        $stats = array();
        $stats['total_bills'] = $this->getTotalBills();
        $stats['total_amount'] = $this->getTotalAmount();
        return $stats;
    }

}
