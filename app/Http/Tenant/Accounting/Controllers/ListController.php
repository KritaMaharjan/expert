<?php
namespace APP\Http\Tenant\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Accounting\Models\Payroll;
use App\Http\Tenant\Accounting\Models\Expense;
use Laracasts\Flash\Flash;

class ListController extends BaseController
{

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

    public function __construct(Payroll $payroll, Request $request, Expense $expense)
    {
        parent::__construct();
        $this->payroll = $payroll;
        $this->request = $request;
        $this->expense = $expense;
    }

    public function index()
    {
        return view('tenant.accounting.account.lists');
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['type', 'billing_date', 'payment_due_date', 'invoice_number', 'created_at'];
            $json = $this->expense->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }
}