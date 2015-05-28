<?php
namespace APP\Http\Tenant\Accounting\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Accounting\Models\Expense;
use Laracasts\Flash\Flash;

class ExpenseController extends BaseController {

    protected $request;

    protected $expense_rules = [
        'billing_date' => 'required|date',
        'payment_due_date' => 'required|date',
        'invoice_number' => 'required|integer'
    ];

    public function __construct(Request $request, Expense $expense)
    {
        parent::__construct();
        $this->request = $request;
        $this->expense = $expense;
    }

    public function index()
    {
        $accounts = $this->getAccountCode('en');
        $tax = \Config::get('tenant.vat');
        $months = \Config::get('tenant.month');
        //$vat = \Config::get('tenant.vat');

        if($this->getCompanyVatRule() == false)
            $vat = false;
        else {
            $vat = \Config::get('tenant.vat');
            $default_vat = $this->getCompanyVatRule();
        }

        return view('tenant.accounting.expense.create', compact('accounts', 'tax', 'months', 'vat', 'default_vat'));
    }

    public function createExpense()
    {
        if($this->request->input('type') == 1)
            $this->expense_rules['supplier_id'] = 'required|integer|exists:fb_suppliers,id';

        $total = $this->getTotal($this->request->all());

        $this->expense_rules['amount_paid'] = 'numeric|maxValue:'.$total.'|minPaymentValue';

        $validator = \Validator::make($this->request->all(), $this->expense_rules);
        if ($validator->fails())
            return $this->fail(['errors' => $validator->messages()]);
            //return redirect()->back()->withErrors($validator)->withInput();

        $result = $this->expense->createExpense($this->request, $this->current_user()->id);

        Flash::success('Expense added successfully!');
        return ($result) ? $this->success(['result' => $result]) : $this->fail(['errors' => 'Something went wrong!']);
        //return tenant()->route('tenant.accounting.index');
    }

    private function getTotal($request)
    {
        $products = $request['text'];
        $amount = $request['amount'];
        $vat = $request['vat'];
        $expense_total = 0;
        foreach ($products as $key => $product) {
            if (isset($amount[$key]) && $amount[$key] > 0) {
                $total = $amount[$key] + ($vat * 0.01 * $amount[$key]);
            }
            $expense_total += $total;
        }
        return $expense_total;
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

    public function edit()
    {
        $id = $this->request->route('id');
        $expense = $this->expense->with('payments', 'products')->find($id)->toArray();
        $accounts = $this->getAccountCode('en');
        $tax = \Config::get('tenant.vat');
        $months= \Config::get('tenant.month');
        return view('tenant.accounting.expense.edit', compact('accounts', 'tax', 'months', 'expense'));
    }

    public function update()
    {
        $id = $this->request->route('id');

        if($this->request->input('type') == 1)
            $this->expense_rules['supplier_id'] = 'required|integer|exists:fb_suppliers,id';

        $validator = \Validator::make($this->request->all(), $this->expense_rules);
        if ($validator->fails())
            return $this->fail(['errors' => $validator->messages()]);

        $updated = $this->expense->updateExpense($this->request, $id);

        if($updated)
            Flash::success('Expense updated successfully!');
        else
            Flash::fail('Something went wrong!');

        return ($updated) ? $this->success(['result' => $updated]) : $this->fail(['errors' => 'Something went wrong!']);

    }

    public function details()
    {
        if($this->request->ajax()) {
            $id = $this->request->route('id');
            $expense = $this->expense->with('payments', 'products')->find($id);
            return view('tenant.accounting.expense.details', compact('expense'));
        }
        return 'Something went wrong';
    }
}