<?php
namespace App\Http\Tenant\Accounting\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Tenant\Accounting\Models\ExpenseProduct as Product;
use App\Http\Tenant\Accounting\Models\ExpensePayment as Payment;

class Expense extends Model
{

    protected $table = "fb_expenses";

    protected $fillable = ['type', 'supplier_id', 'billing_date', 'payment_due_date', 'invoice_number', 'invoice_number', 'bill_image', 'is_paid'];

    protected $primaryKey = "id";

    function payments()
    {
        return $this->hasMany('App\Http\Tenant\Accounting\Models\ExpensePayment');
    }

    function products()
    {
        return $this->hasMany('App\Http\Tenant\Accounting\Models\ExpenseProduct');
    }

    public function createExpense(Request $request)
    {
        // Start transaction!
        DB::beginTransaction();
        try {
            $expense = Expense::create([
                'type' => $request['type'],
                'supplier_id' => isset($request['supplier_id']) ? $request['supplier_id'] : null,
                'billing_date' => $request['billing_date'],
                'payment_due_date' => $request['payment_due_date'],
                'invoice_number' => $request['invoice_number'],
                'bill_image' => $request['bill_image'],
                'is_paid' => ($request['is_paid'])? 1 : 0
            ]);

            $expense_total = 0;
            $expense_paid = 0;
            $products = $request['text'];
            $amount = $request['amount'];
            $vat = $request['vat'];
            $account_code_id = $request['account_code_id'];

            foreach ($products as $key => $product) {
                if (isset($amount[$key]) && $amount[$key] > 0) {
                    $total = $amount[$key] + ($vat[$key] * 0.01 * $amount[$key]);
                    Product::create([
                        'expense_id' => $expense->id,
                        'text' => $product,
                        'amount' => $amount[$key],
                        'vat' => $vat[$key],
                        'total' => $total,
                        'account_code_id' => $account_code_id[$key],
                    ]);
                    $expense_total += $total;
                }

            }
            $expense_remaining = $expense_total;
            if($request['is_paid']) {
                Payment::create([
                    'expense_id' => $expense->id,
                    'amount_paid' => $request['amount_paid'],
                    'payment_method' => $request['payment_method'],
                    'payment_date' => $request['payment_date']
                ]);
                $expense_paid += $request['amount_paid'];
                $expense_remaining = $expense_total - $expense_paid;
            }

            $expense->total = $expense_total;
            $expense->paid = $expense_paid;
            $expense->remaining = $expense_remaining;

            DB::commit();
            return $expense->toArray();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateExpense(Request $request, $id) {
        $expense = Expense::find($id);

        if(!empty($expense)) {
            // Start transaction!
            DB::beginTransaction();
            try {
                //update expense
                $expense->type = $request['type'];
                $expense->supplier_id = isset($request['supplier_id']) ? $request['supplier_id'] : null;
                $expense->billing_date = $request['billing_date'];
                $expense->payment_due_date = $request['payment_due_date'];
                $expense->invoice_number = $request['invoice_number'];
                $expense->bill_image = $request['bill_image'];
                $expense->is_paid = ($request['is_paid']) ? 1 : 0;
                $expense->save();


                //deleted related products
                Product::where('expense_id', $id)->delete();

                //add products
                $products = $request['text'];
                $amount = $request['amount'];
                $vat = $request['vat'];
                $account_code_id = $request['account_code_id'];

                foreach ($products as $key => $product) {
                    if (isset($amount[$key]) && $amount[$key] > 0) {
                        $total = $amount[$key] + ($vat[$key] * 0.01 * $amount[$key]);
                        Product::create([
                            'expense_id' => $expense->id,
                            'text' => $product,
                            'amount' => $amount[$key],
                            'vat' => $vat[$key],
                            'total' => $total,
                            'account_code_id' => $account_code_id[$key],
                        ]);
                    }
                }

                DB::commit();
                return $expense->toArray();

            } catch (\Exception $e) {
                DB::rollback();
                return false;
            }
        }
        return false;
    }

    public function payExpense(Request $request, $id) {
        $payment_info = Payment::create([
            'expense_id' => $id,
            'amount_paid' => $request['amount_paid'],
            'payment_method' => $request['payment_method'],
            'payment_date' => $request['payment_date']
        ]);
        return $payment_info->toArray();
    }

    public function deleteExpense($id)
    {
        $expense = Expense::find($id);
        if (!empty($expense)) {
            // Start transaction!
            DB::beginTransaction();
            try {
                //delete expense
                $expense->delete();
                //deleted related products
                Product::where('expense_id', $id)->delete();
                //deleted related payments
                Payment::where('expense_id', $id)->delete();
                DB::commit();
                return true;
            } catch (\Exception $e) {
                DB::rollback();
                return false;
            }
        }
        return false;
    }

    function dataTablePagination(Request $request, array $select = array(), $is_offer = false)
    {
        if ((is_array($select) AND count($select) < 1)) {
            $select = "*";
        }

        $take = ($request->input('length') > 0) ? $request->input('length') : 15;
        $start = ($request->input('start') > 0) ? $request->input('start') : 0;

        $search = $request->input('search');
        $search = $search['value'];
        $order = $request->input('order');
        $column_id = $order[0]['column'];
        $columns = $request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $expenses = array();
        $query = $this->select($select)->where('is_paid', 0);

        if ($orderColumn != '' AND $orderdir != '') {
            if ($orderColumn != 'invoice_date')
                $query = $query->orderBy($orderColumn, $orderdir);
            else
                $query = $query->orderBy('created_at', $orderdir);
        }

        if ($search != '') {
            $query = $query->where('invoice_number', 'LIKE', "%$search%");
        }
        $expenses['total'] = $query->count();


        $query->skip($start)->take($take);

        $data = $query->get();

        foreach ($data as $key => &$value) {
            $value->invoice_number = '<a href="#" data-toggle="modal" data-url="'.tenant()->url('accounting/' . $value->id . '/pay').'" data-target="#fb-modal">' . $value->invoice_number . '</a>';
            $value->type = ($value->type == 1)? 'Supplier' : 'Cash';
        }

        $expenses['data'] = $data->toArray();

        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $expenses['total'];
        $json->recordsFiltered = $expenses['total'];
        $json->data = $expenses['data'];

        return $json;
    }

}
