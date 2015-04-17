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
        dd($request->input());
        dd($request['text']);
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

            if($request['is_paid']) {
                Payment::create([
                    'expense_id' => $expense->id,
                    'amount_paid' => $request['amount_paid'],
                    'payment_method' => $request['payment_method'],
                    'payment_date' => $request['payment_date']
                ]);
            }

            DB::commit();
            return $expense->toArray();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

}
