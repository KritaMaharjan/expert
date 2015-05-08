<?php
namespace App\Http\Tenant\Statistics\Repositories;


use App\Http\Tenant\Accounting\Models\Expense;
use App\Http\Tenant\Accounting\Models\Payroll;
use App\Http\Tenant\Inventory\Models\Product;
use App\Http\Tenant\Invoice\Models\BillProducts;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountRepository {

    private $from;
    private $to;

    /**
     * @return float
     * Total income after removing all the expenditures
     */
    function getTotalIncome() {
        $bill_repo = new BillRepository();
        $bill_paid = $bill_repo->getAmountPaid();
        $sales_cost = $this->getSalesCost();
        $expenses = $this->getTotalExpenses();
        $salaries = $this->getSalaryPaid();

        $total = $bill_paid - $sales_cost - $expenses - $salaries;
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
        $stats['total_income'] = float_format($this->getTotalIncome());
        $stats['total_expenses'] = float_format($this->getTotalExpenses());
        $stats['total_paid_salary'] = float_format($this->getSalaryPaid());
        $stats['total_sales_cost'] = float_format($this->getSalesCost());
        return $stats;
    }

}
