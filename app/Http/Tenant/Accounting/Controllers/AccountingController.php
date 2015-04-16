<?php
namespace APP\Http\Tenant\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Accounting\Models\Payroll;
use Laracasts\Flash\Flash;

class AccountingController extends BaseController {

    protected $payroll;
    protected $request;

    protected $payroll_rules = [
        'user_id' => 'required|exists:fb_users,id',
        'type' => 'required',
        'worked' => 'required|integer|min:1',
        'rate' => 'required|numeric|min:1',
        'other_payment' => 'numeric',
        'description' => 'required_with:other_payment',
        'tax_rate' => 'required|numeric',
        'payroll_tax' => 'required|numeric',
        //'vacation_fund' => 'required|numeric',
        'payment_date' => 'required|date',
    ];

    protected $expense_rules = [
        'supplier_id' => 'required|integer|min:1',
        'rate' => 'required|numeric|min:1',
        'other_payment' => 'numeric',
        'description' => 'required_with:other_payment',
        'tax_rate' => 'required|numeric',
        'payroll_tax' => 'required|numeric',
        //'vacation_fund' => 'required|numeric',
        'payment_date' => 'required|date',
    ];

    public function __construct(Payroll $payroll, Request $request)
    {
        parent::__construct();
        $this->payroll = $payroll;
        $this->request = $request;
    }

    public function index()
    {
        return view('tenant.accounting.account.lists');
    }

    public function expense()
    {
        $accounts = $this->getAccountCode('en');
        $tax = \Config::get('tenant.vat');
        $months= \Config::get('tenant.month');
        return view('tenant.accounting.account.expense', compact('accounts', 'tax', 'months'));
    }

    public function getAccountCode($lang)
    {
        $accounts = \Config::get('accounts.codes');
        $codes = array('' => 'Select Account Expense');
        foreach($accounts as $key => $account)
        {
            $codes[$key] = $account[$lang];
        }
        return $codes;
    }

    public function payroll()
    {
        return view('tenant.accounting.account.payroll');
    }

    public function addPayroll()
    {
        return view('tenant.accounting.account.createPayroll');
    }

    public function createPayroll()
    {
        $validator = \Validator::make($this->request->all(), $this->payroll_rules);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();
        $this->payroll->createPayroll($this->request);
        Flash::success('Payslip added successfully!');
        return tenant()->route('tenant.accounting.account.payroll');
    }

    public function employeePayrollDetails()
    {
        $employee_id = $this->request->route('employeeId');
        $year = $this->request->get('year');
        $month = $this->request->get('month');
        $result = $this->payroll->getPayrolls($employee_id, $year, $month);
        return ($result) ? $this->success(['details' => $result]) : $this->fail(['errors' => 'Something went wrong!']);
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