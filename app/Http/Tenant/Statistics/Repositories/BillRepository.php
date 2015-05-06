<?php
namespace App\Http\Tenant\Statistics\Repositories;

use App\Http\Tenant\Invoice\Models\Bill;
use Carbon\Carbon;

class BillRepository {

    /**
     * @return int
     * Total number of customers
     */
    function getBillsTotal() {
        $total = Bill::where('type', 0)->count();
        return $total;
    }

    /**
     * @return int
     * Total number of sent emails
     */
    function getTotalBilled() {
        $total = Bill::select('total')->where('type', 0)->sum('total');
        return $total;
    }

    /**
     * @return int
     * Total number of active customers
     */
    function getAmountPaid() {
        $total = Bill::select('paid')->where('type', 0)->sum('paid');
        return $total;
    }

    /**
     * @return array
     * Total Statistics for customers
     */
    function getAvgPaymentTime() {

    }

    /**
     * @return int
     * Total number of active customers
     */
    function getPastDue() {
        $today = Carbon::today();
        $total = Bill::where('due_date', '>',  $today)->count();
        return $total;
    }

    /**
     * @return int
     * Total number of active customers
     */
    function getNotCollection() {
        $total = Bill::where('status', '!=', 1)->where('type', 0)->count();
        return $total;
    }

    /**
     * @return int
     * Total number of active customers
     */
    function getOffersTotal() {
        $total = Bill::where('type', 1)->count();
        return $total;
    }

    /**
     * @return int
     * Total number of active customers
     */
    function getBillStats() {
        $stats = array();
        $stats['total_bills'] = $this->getBillsTotal();
        $stats['total_billed'] = $this->getTotalBilled();
        $stats['total_paid'] = $this->getAmountPaid();
        $stats['past_due'] = $this->getPastDue();
        $stats['not_collection'] = $this->getNotCollection();
        $stats['total_offers'] = $this->getOffersTotal();
        return $stats;
    }

}
