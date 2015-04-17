<?php
namespace App\Http\Tenant\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ExpensePayment extends Model
{

    protected $table = "fb_expense_payment";

    protected $fillable = ['expense_id', 'amount_paid', 'payment_method', 'payment_date'];

    protected $primaryKey = "id";

}
