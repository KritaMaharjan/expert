<?php
namespace App\Http\Tenant\Statistics\Repositories;

use App\Http\Tenant\Invoice\Models\Bill;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BillRepository {

    private $from;
    private $to;

    /**
     * @return int
     * Total number of bills created
     */
    function getBillsTotal() {
        $total = Bill::whereBetween('created_at', array($this->from, $this->to))->where('type', 0)->count();
        return $total;
    }

    /**
     * @return float
     * Total amount in bills
     */
    function getTotalBilled() {
        $total = Bill::select('total')->where('type', 0)->whereBetween('created_at', array($this->from, $this->to))->sum('total');
        return $total;
    }

    /**
     * @return float
     * Total amount paid
     */
    function getAmountPaid() {
        $total = Bill::select('paid')->where('type', 0)->whereBetween('created_at', array($this->from, $this->to))->sum('paid');
        return $total;
    }

    /**
     * @return int
     * Average time for full payment from the date bill was issued (created)
     */
    function getAvgPaymentTime() {
        $query = Bill::select(DB::raw("AVG(DATEDIFF(full_payment_date, created_at))AS days"))->whereNotNull('full_payment_date')->whereBetween('created_at', array($this->from, $this->to))->first();
        return (int)$query->days;
    }

    /**
     * @return int
     * Total number of bills that past the due date and not paid yet
     */
    function getPastDue() {
        $today = Carbon::today();
        $total = Bill::where('due_date', '>',  $today)->where('payment', '!=', 1)->whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return int
     * Total number of bills that are not in collection
     */
    function getNotCollection() {
        $total = Bill::where('status', '!=', 1)->where('type', 0)->whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return int
     * Total number of offers
     */
    function getOffersTotal() {
        $total = Bill::where('type', 1)->whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return array
     * Statistics for Bill section
     */
    function getBillStats($filter = null) {
        if($filter != null) {
            $this->from = $filter['start_date'];
            $this->to = $filter['end_date'];
        } else {
            $this->from = '0000-00-00';
            $this->to = Carbon::now();
        }

        $stats = array();
        $stats['total_bills'] = $this->getBillsTotal();
        $stats['total_billed'] = $this->getTotalBilled();
        $stats['total_paid'] = $this->getAmountPaid();
        $stats['avg_payment_time'] = $this->getAvgPaymentTime();
        $stats['past_due'] = $this->getPastDue();
        $stats['not_collection'] = $this->getNotCollection();
        $stats['total_offers'] = $this->getOffersTotal();
        return $stats;
    }

}
