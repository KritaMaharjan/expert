<?php
namespace APP\Http\Tenant\Accounting\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Accounting\Libraries\Record;
use App\Http\Tenant\Invoice\Models\Bill;
use App\Models\Tenant\Customer;

class TransactionController extends BaseController {


    function index(Record $record)
    {
        $bill = Bill::find(1);
        $customer = Customer::find(1);

        $d = $record->sendABill($bill, $customer, 100, 8);

        dd($d);


        return view('tenant.accounting.transaction.index');
    }

    function more()
    {

    }

} 