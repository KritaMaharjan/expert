<?php
namespace APP\Http\Tenant\Accounting\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Accounting\Libraries\Record;
use App\Http\Tenant\Accounting\Models\Transaction;
use App\Http\Tenant\Invoice\Models\Bill;
use App\Models\Tenant\Customer;

class TransactionController extends BaseController {

    /**
     * @param Transaction $transaction
     * @return \Illuminate\View\View
     */
    function index(Transaction $transaction)
    {
        $bill = Bill::find(1);
        $customer = Customer::find(1);
        Record::sendABill($bill, $customer, 2500, 15);
        $transactions = $transaction->select()->with('entries')->get();


        return view('tenant.accounting.transaction.index', compact('transactions'));
    }
}
