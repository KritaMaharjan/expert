<?php
namespace APP\Http\Tenant\Accounting\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Accounting\Libraries\Record;
use App\Http\Tenant\Accounting\Models\Transaction;
use App\Http\Tenant\Invoice\Models\Bill;
use App\Models\Tenant\Customer;
use Illuminate\Http\Request;

class TransactionController extends BaseController {

    /**
     * @param Transaction $transaction
     * @param Request $request
     * @return \Illuminate\View\View
     */
    function index(Transaction $transaction, Request $request)
    {
        $transactions = $transaction->getPagination();

        $get = ['type' => $request->get('type'), 'from' => $request->get('from'), 'to' => $request->get('to')];
        $get = (object)$get;

        return view('tenant.accounting.transaction.index', compact('transactions', 'get'));
    }
}
