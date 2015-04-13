<?php
namespace APP\Http\Tenant\Accounting\Controllers;
use App\Http\Controllers\Tenant\BaseController;

class AccountingController extends BaseController {

    protected $task;
    protected $request;

    protected $rules = [
        'subject' => 'required|between:2,100',
        'body' => 'required',
        'due_date' => 'required|date'
    ];

    public function __construct(Tasks $task, Request $request)
    {
        parent::__construct();
        $this->task = $task;
        $this->request = $request;
    }

    public function expense()
    {
        return view('tenant.accounting.account.expense');
    }

    public function lists()
    {
        return view('tenant.accounting.account.lists');
    }

    public function payroll()
    {
        return view('tenant.accounting.account.payroll');
    }

    public function createPayroll()
    {

    }

    public function vat()
    {
        return view('tenant.accounting.account.vat');
    }

    public function setup()
    {
        return view('tenant.accounting.account.setup');
    }

    public function newBusiness()
    {
        return view('tenant.accounting.account.new_business');
    }

    public function open()
    {
        return view('tenant.accounting.account.open');
    }

    public function close()
    {
        return view('tenant.accounting.account.close');
    }


}