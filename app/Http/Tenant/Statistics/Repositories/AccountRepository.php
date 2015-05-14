<?php
namespace App\Http\Tenant\Statistics\Repositories;


use App\Http\Tenant\Accounting\Models\Expense;
use App\Http\Tenant\Accounting\Models\Payroll;
use App\Http\Tenant\Inventory\Models\Product;
use App\Http\Tenant\Invoice\Models\Bill;
use App\Http\Tenant\Invoice\Models\BillProducts;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountRepository {

    private $from;
    private $to;
    private $chartData;

    /**
     * @return float
     * Total income after removing all the expenditures
     */
    function getTotalIncome() {
        $bill_paid = $this->getAmountPaid();
        $sales_cost = $this->getSalesCost();
        $expenses = $this->getTotalExpenses();
        $salaries = $this->getSalaryPaid();

        $total = $bill_paid - $sales_cost - $expenses - $salaries;
        return $total;
    }

    /**
     * @return float
     * Total amount paid
     */
    function getAmountPaid() {
        $total = Bill::select('paid')
            ->where('type', 0)
            ->whereBetween('created_at', array($this->from, $this->to))
            ->sum('paid');
        return $total;
    }

    /**
     * @return float
     * Total amount in expenses
     */
    function getTotalExpenses() {
        $total = Expense::select('amount')->whereBetween('created_at', array($this->from, $this->to))->sum('amount');
        return $total;
    }

    /**
     * @return float
     * Total salary paid to the employees
     */
    function getSalaryPaid() {
        $total = Payroll::select('total_paid')->whereBetween('created_at', array($this->from, $this->to))->sum('total_paid');
        return $total;
    }

    /**
     * @return int
     * Average time for full payment from the date bill was issued (created)
     */
    function getAdvertisingExpenses() {
        $query = Bill::select(DB::raw("AVG(DATEDIFF(full_payment_date, created_at))AS days"))->whereNotNull('full_payment_date')->whereBetween('created_at', array($this->from, $this->to))->first();

        return (!empty($query)) ? (int)$query->days : 0;
    }

    /**
     * @return float
     * Total purchase cost of products used in bills
     */
    function getSalesCost() {
        $bill_products = BillProducts::select('product_id', DB::raw('count(product_id) as total'))->whereBetween('created_at', array($this->from, $this->to))->groupBy('product_id')->get();

        $sales_cost = 0;
        foreach($bill_products as $product) {
            $purchase_cost = Product::select('purchase_cost')->find($product->product_id)->purchase_cost;
            $total_cost = $purchase_cost * $product->total;
            $sales_cost += $total_cost;
        }

        return $sales_cost;
    }

    /**
     * @return array
     * Total number of collection activity each day
     */
    function getChartData() {

        //$totalBills = $this->getIncomeChartData();
        $totalBills = $this->getExpensesChartData();
        $chartData = array();
        foreach($totalBills as $data) {
            $chartData[] = ['x' => $data->date, 'value1' => $data->total, 'value2' => 0, 'value3' => 0, 'value4' => 0, 'value5' => 0];
        }
        $this->chartData = $chartData;

        $expenses = $this->getExpensesChartData();
        $this->addOrCreateArray($expenses, 2);

        $salaries = $this->getSalariesChartData();
        $this->addOrCreateArray($salaries, 3);

        //$ads = $this->getAdvertisementChartData();
        //$this->addOrCreateArray($ads, 4);

        $sales = $this->getSalesChartData();
        $this->addOrCreateArray($sales, 5);

        return ($this->chartData);
    }

    function getIncomeChartData() {
        $bill_paid = $this->getAmountPaidChartData();
        $sales_cost = $this->getSalesChartData();
        $expenses = $this->getExpensesChartData();
        $salaries = $this->getSalariesChartData();

        //$total = $bill_paid - $sales_cost - $expenses - $salaries;
        $expenditure = array_merge($sales_cost, $expenses, $salaries);
        //return $total;
    }

    function getAmountPaidChartData() {
        $total = Bill::select([
                    DB::raw('DATE(created_at) AS date'),
                    DB::raw('SUM(paid) AS total'),
                ])
                ->where('type', 0)
                ->whereBetween('created_at', array($this->from, $this->to))
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();
        return $total;
    }

    function getExpensesChartData() {

        $chartDatas = Expense::select([
                    DB::raw('DATE(created_at) AS date'),
                    DB::raw('SUM(amount) AS total'),
                ])
                ->whereBetween('created_at', array($this->from, $this->to))
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();
        return $chartDatas;
    }

    function getSalariesChartData() {

        $chartDatas = Payroll::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('SUM(total_paid) AS total'),
        ])
            ->whereBetween('created_at', array($this->from, $this->to))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        return $chartDatas;
    }

    function getAdvertisementChartData() {
        $chartDatas = CourtCase::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS total'),
        ])
            ->whereBetween('created_at', array($this->from, $this->to))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        return $chartDatas;
    }

    function getSalesChartData() {
        $bill_products =
            BillProducts::select([
                'product_id',
                DB::raw('DATE(created_at) AS date'),
                DB::raw('COUNT(id) AS total')])
                ->whereBetween('created_at', array($this->from, $this->to))
                ->groupBy('product_id', 'date')
                ->orderBy('date', 'ASC')
                ->get();

        $current_date = '';
        $key = 0;
        $data = array();

        foreach($bill_products as $product) {
            $purchase_date = $product->date;

            if($current_date == '' || $purchase_date != $current_date) {
                $current_date = $purchase_date;
                end($data);
                $key = (key($data) != null) ? key($data) : 0;
                $key = $key + 1;

                $new_entry = array('date' => $purchase_date, 'total' => 0);
                $data[$key] = (object)$new_entry;
                //$data[$key]['date'] = $purchase_date;
                //$data[$key]['total'] = 0;
            }

            $purchase_cost = Product::select('purchase_cost')->find($product->product_id)->purchase_cost;
            $total_cost = $purchase_cost * $product->total;
            $data[$key]->total += $total_cost;
        }
        return $data;
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

                for($i = 1; $i <= 5; $i++)
                {
                    if($i == $index)
                        $this->chartData[$key]['value'.$i] = float_format($data->total);
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

    /**
     * @return array
     * Statistics for Accounts section
     */
    function getAccountStats($filter = null) {
        if($filter != null) {
            $this->from = $filter['start_date'];
            $this->to = $filter['end_date'];
        } else {
            $this->from = '0000-00-00';
            $this->to = Carbon::now();
        }
        $stats = array();
        $stats['accounts_chart_data'] = $this->getChartData();
        $stats['total_income'] = float_format($this->getTotalIncome());
        $stats['total_expenses'] = float_format($this->getTotalExpenses());
        $stats['total_paid_salary'] = float_format($this->getSalaryPaid());
        $stats['total_sales_cost'] = float_format($this->getSalesCost());
        return $stats;
    }

}
