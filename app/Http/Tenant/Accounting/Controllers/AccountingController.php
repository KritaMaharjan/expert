<?php
namespace APP\Http\Tenant\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Accounting\Models\Payroll;
use App\Http\Tenant\Accounting\Models\Expense;
use Laracasts\Flash\Flash;
use App\Http\Tenant\Accounting\Models\Entry;
use App\Http\Tenant\Accounting\Models\VatPeriod;

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

    public function __construct(Payroll $payroll, Request $request, Expense $expense, Entry $entry, VatPeriod $vatPeriod)
    {
        parent::__construct();
        $this->payroll = $payroll;
        $this->request = $request;
        $this->expense = $expense;
        $this->entry = $entry;
        $this->vatPeriod = $vatPeriod;
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
        $vat_entries = $this->entry->getVatEntries();
        return view('tenant.accounting.vat.index', compact('vat_entries'));
    }

    public function entries()
    {
        if($this->request->ajax()) {
            $vat_entries = $this->entry->getVatEntries($this->request->all());
            $vat_period = $this->vatPeriod->getVatPeriod($this->request->all());
            $template = \View::make('tenant.accounting.vat.entries', compact('vat_entries', 'vat_period'))->render();
            return $this->success(['details' => $template]);
        }
        return false;
    }

    public function action()
    {
        if($this->request->ajax()) {
            $action = $this->request->route('action');
            $updated = $this->vatPeriod->changeStatus($this->request->all(), $action);
            Flash::success('Successfully marked '.$action);
            return ($updated)? $this->success(['details' => 'Successfully marked '.$action]): $this->fail(['details' => 'Something went wrong!']);
        }
        return false;
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

    public function listing()
    {

    }


}