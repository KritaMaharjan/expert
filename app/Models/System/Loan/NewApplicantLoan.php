<?php
namespace App\Models\System\Loan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NewApplicantLoan extends Model
{

    protected $table = 'new_applicant_loans';
    protected $fillable = ['amount', 'ownership', 'for_property', 'applicant_id', 'secured_by', 'loan_purpose', 'deposit_paid', 'settlement_date', 'loan_usage', 'total_loan_term', 'loan_type', 'fixed_rate_term', 'io_term', 'repayment_type', 'interest_rate'];

    public $timestamps = false;
} 