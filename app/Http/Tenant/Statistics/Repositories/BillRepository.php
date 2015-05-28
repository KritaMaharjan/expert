<?php
namespace App\Http\Tenant\Statistics\Repositories;

use App\Http\Tenant\Invoice\Models\Bill;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BillRepository {

    private $from;
    private $to;
    private $chartData;

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
        $query = Bill::select(DB::raw("(DATEDIFF(full_payment_date, created_at))AS days"))->whereNotNull('full_payment_date')->whereBetween('created_at', array($this->from, $this->to))->first();
        //$query = Bill::select(DB::raw("AVG(DATEDIFF(full_payment_date, DATE(created_at)))AS days"))->whereNotNull('full_payment_date')->whereBetween('created_at', array($this->from, $this->to))->first();
        if(!empty($query))
            return (int)$query->days;
        else
            return 0;
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
     * Total number of bill activity each day
     */
    function getChartData() {

        $totalBills = $this->getTotalChartData();
        $chartData = array();
        foreach($totalBills as $data) {
            $chartData[] = ['x' => $data->date, 'value1' => $data->total, 'value2' => 0, 'value3' => 0];
        }
        $this->chartData = $chartData;
        //$paymentsBills = $this->getAveragePaymentChartData();
        //$this->addOrCreateArray($paymentsBills, 2);

        //$pastDueBills = $this->getPastDueChartData();
        $notCollectionBills = $this->getNotCollectionChartData();
        $this->addOrCreateArray($notCollectionBills, 2);

        $totalOffers = $this->getOffersChartData();
        $this->addOrCreateArray($totalOffers, 3);

        return ($this->chartData);
    }

    function addOrCreateArray($new_data, $index) {
        foreach($new_data as $data) {
            $exists = $this->in_assoc($data->date, $this->chartData);
            if($exists  !== false)
                $this->chartData[$exists]['value'.$index] = $data->total;
            else {
                $this->chartData[]['x'] = $data->date;
                end($this->chartData);
                //get key of the last array
                $key = key($this->chartData);

                for($i = 1; $i <= 3; $i++)
                {
                    if($i == $index)
                        $this->chartData[$key]['value'.$i] = $data->total;
                    else
                        $this->chartData[$key]['value'.$i] = 0;
                }
            }
        }
    }

    //check if a value exists in associative array
    function in_assoc($needle, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['x'] == $needle) {
                return $key;
            }
        }
        return false;
    }

    /*
     * total bills
     */
    function getTotalChartData() {
        $chartDatas = Bill::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS total'),
        ])
            ->whereBetween('created_at', array($this->from, $this->to))
            ->where('type', 0) // type bill
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        return $chartDatas;
    }

    function getNotCollectionChartData() {
        $chartDatas = Bill::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS total'),
        ])
            ->where('status', '!=', 1) // status not collection
            ->where('type', 0)
            ->whereBetween('created_at', array($this->from, $this->to))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        return $chartDatas;
    }

    function getOffersChartData() {
        $chartDatas = Bill::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS total'),
        ])
            ->where('type', 1) // type offer
            ->whereBetween('created_at', array($this->from, $this->to))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        return $chartDatas;
    }

    /**
     * @return array
     * Statistics for Bill section
     */
    function getBillStats($filter = null) {
        if($filter != null && $filter['start_date'] != '' && $filter['end_date'] != '') {
            $this->from = Carbon::createFromFormat('Y-m-d', $filter['start_date'])->subDay();
            $this->to = Carbon::createFromFormat('Y-m-d', $filter['end_date'])->addDay();
        } else {
            $this->from = '0000-00-00';
            $this->to = Carbon::now();
        }

        $stats = array();
        $stats['bill_chart_data'] = $this->getChartData();
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
