<?php
namespace APP\Http\Tenant\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Accounting\Models\Payroll;
use App\Http\Tenant\Accounting\Models\Expense;
use Illuminate\Support\Facades\Validator;
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

    function pay()
    {
        $id = $this->request->route('id');
        /*$product = $this->product->find($id);
        if ($product == null) {
            show_404();
        }*/
        return view('tenant.accounting.account.pay', compact('product'));
    }

    public function RegisterPayment()
    {
        $id = $this->request->route('id');
        $expense = $this->expense->find($id);

        $expense_rules = [
            'amount_paid' => 'required|numeric|maxValue:'.$expense->remaining,
            'payment_date' => 'required|date'
        ];

        if (empty($expense))
            return $this->fail(['error' => 'Invalid Expense ID']);
        $validator = Validator::make($this->request->all(), $expense_rules);

        if ($validator->fails())
            return $this->fail(['errors' => $validator->messages()]);

        $result = $this->expense->payExpense($this->request, $id, $this->current_user()->id);
        return ($result) ? $this->success(['result' => $result]) : $this->fail(['errors' => 'Something went wrong!']);
    }

    public function deleteExpense()
    {
        $id = $this->request->route('id');
        $result = $this->expense->deleteExpense($id);
        if ($result)
            return $this->success(['message' => 'Expense deleted Successfully!']);
        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'type', 'remaining', 'billing_date', 'payment_due_date', 'invoice_number', 'created_at'];
            $json = $this->expense->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }
}