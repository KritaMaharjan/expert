<?php
namespace App\Http\Tenant\Statistics\Repositories;

use App\Http\Tenant\Email\Models\Email;
use App\Models\Tenant\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerRepository {

    private $from;
    private $to;
    /**
     * @return int
     * Total number of customers
     */
    function getCustomersTotal() {
        $total = Customer::whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return array
     * Total number of customers activity each day
     */
    function getChartData() {

        $totalCustomers = $this->getTotalChartData();
        $chartDataByDay = array();
        foreach($totalCustomers as $data) {
            $chartDataByDay[] = ['x' => $data->date, 'value1' => $data->total, 'value2' => 0, 'value3' => 0];
        }

        $activeCustomers = $this->getActiveChartData();

        foreach($activeCustomers as $data) {
            $exists = $this->in_assoc($data->date, $chartDataByDay);
            if($exists  !== false)
                $chartDataByDay[$exists]['value2'] = $data->total;
            else
                $chartDataByDay[] = ['x' => $data->date, 'value1' => 0, 'value2' => $data->total, 'value3' => 0];
        }

        $totalEmails = $this->getEmailChartData();
        foreach($totalEmails as $data) {
            $exists = $this->in_assoc($data->date, $chartDataByDay);
            if($exists  !== false)
                $chartDataByDay[$exists]['value3'] = $data->total;
            else
                $chartDataByDay[] = ['x' => $data->date, 'value1' => 0, 'value2' => 0, 'value3' => $data->total];
        }

        return ($chartDataByDay);
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
     * total customers
     */
    function getTotalChartData() {
        $chartDatas = Customer::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS total'),
        ])
            ->whereBetween('created_at', array($this->from, $this->to))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        return $chartDatas;
    }

    /*
     * active customers
     */
    function getActiveChartData() {

        $chartDatas = Customer::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS total'),
        ])
            ->where('status', 1)
            ->whereBetween('created_at', array($this->from, $this->to))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        return $chartDatas;
    }

    /*
     * total emails
     */
    function getEmailChartData() {

        $chartDatas = Email::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS total'),
        ])
            ->whereBetween('created_at', array($this->from, $this->to))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        return $chartDatas;
    }

    /**
     * @return int
     * Total number of sent emails
     */
    function getEmailsTotal() {
        $total = Email::whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return int
     * Total number of active customers
     */
    function getActiveCustomers() {
        $total = Customer::where('status', 1)->whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return array
     * Total Statistics for customers
     */
    function getCustomerStats($filter = null) {
        if($filter != null) {
            $this->from = $filter['start_date'];
            $this->to = $filter['end_date'];
        } else {
            $this->from = '0000-00-00';
            $this->to = Carbon::now();
        }

        $stats = array();
        $stats['customers_chart_data'] = $this->getChartData();
        $stats['total_customers'] = $this->getCustomersTotal();
        $stats['total_emails'] = $this->getEmailsTotal();
        $stats['total_active_customers'] = $this->getActiveCustomers();
        return $stats;
    }

}
