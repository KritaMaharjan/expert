<?php
namespace App\Http\Tenant\Statistics\Repositories;


use App\Http\Tenant\Accounting\Models\Expense;
use App\Http\Tenant\Accounting\Models\Payroll;

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
     * Total amount in bills
     */
    function getTotalExpenses() {
        $total = Expense::select('amount')->sum('amount');
        return $total;
    }

    /**
     * @return float
     * Total amount paid
     */
    function getSalaryPaid() {
        $total = Payroll::select('total_paid')->sum('total_paid');
        return $total;
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
     * @return int
     * Total number of bills that past the due date and not paid yet
     */
    function getSalesCost() {
        $today = Carbon::today();
        $total = Bill::where('due_date', '>',  $today)->where('payment', '!=', 1)->count();
        return $total;
    }

    /**
     * @return array
     * Statistics for Accounts section
     */
    function getAccountStats() {
        $stats = array();
        $stats['total_expenses'] = $this->getTotalExpenses();
        $stats['total_paid_salary'] = $this->getSalaryPaid();
        return $stats;
    }

}
