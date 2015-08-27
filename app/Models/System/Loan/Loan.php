<?php
namespace App\Models\System\Loan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Loan extends Model
{

    protected $table = 'loans';
    protected $fillable = ['loan_purpose', 'amount', 'area', 'loan_type', 'ex_leads_id', 'interest_rate', 'bank_name', 'interest_type', 'interest_date_till'];
    public $timestamps = false;
} 