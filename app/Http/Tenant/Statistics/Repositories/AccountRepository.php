<?php
namespace App\Http\Tenant\Statistics\Repositories;


use App\Http\Tenant\Accounting\Models\Expense;
use App\Http\Tenant\Accounting\Models\Payroll;
use App\Http\Tenant\Inventory\Models\Product;
use App\Http\Tenant\Invoice\Models\BillProducts;
use Illuminate\Support\Facades\DB;

class AccountRepository {

    /**
     * @return int
     * Total number of bills created
     */
    function getTotalIncome() {
        $total = Bill::where('type', 0)->count();
        return $total;
    }

    /**
     * @return float
     * Total amount in expenses
     */
    function getTotalExpenses() {
        $total = Expense::select('amount')->sum('amount');
        return float_format($total);
    }

    /**
     * @return float
     * Total salary paid to the employees
     */
    function getSalaryPaid() {
        $total = Payroll::select('total_paid')->sum('total_paid');
        return float_format($total);
    }

    /**
     * @return int
     * Average time for full payment from the date bill was issued (created)
     */
    function getAdvertisingExpenses() {
        $query = Bill::select(DB::raw("AVG(DATEDIFF(full_payment_date, created_at))AS days"))->whereNotNull('full_payment_date')->first();
        return (int)$query->days;
    }

    /**
     * @return float
     * Total purchase cost of products used in bills
     */
    function getSalesCost() {
        $bill_products = BillProducts::select('product_id', DB::raw('count(product_id) as total'))->groupBy('product_id')->get();

        $sales_cost = 0;
        foreach($bill_products as $product) {
            $purchase_cost = Product::select('purchase_cost')->where('product_id', $product->product_id)->first();
            $total_cost = $purchase_cost * $product->total;
            $sales_cost += $total_cost;
        }

        return $sales_cost;
    }

    /**
     * @return array
     * Statistics for Accounts section
     */
    function getAccountStats() {
        $stats = array();
        $stats['total_expenses'] = $this->getTotalExpenses();
        $stats['total_paid_salary'] = $this->getSalaryPaid();
        $stats['total_sales_cost'] = $this->getSalesCost();
        return $stats;
    }

}
