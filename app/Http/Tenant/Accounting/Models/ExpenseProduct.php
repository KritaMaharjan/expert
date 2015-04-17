<?php
namespace App\Http\Tenant\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseProduct extends Model
{

    protected $table = "fb_expense_products";

    protected $fillable = ['expense_id', 'text', 'amount', 'total', 'vat', 'account_code_id'];

    protected $primaryKey = "id";

}
