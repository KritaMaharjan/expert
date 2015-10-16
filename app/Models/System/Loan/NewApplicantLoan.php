<?php
namespace App\Models\System\Loan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NewApplicantLoan extends Model
{

    protected $table = 'new_applicant_loans';
    protected $fillable = ['amount', 'application_id', 'ownership', 'for_property', 'applicant_id', 'secured_by', 'loan_purpose', 'deposit_paid', 'settlement_date', 'loan_usage', 'total_loan_term', 'loan_type', 'fixed_rate_term', 'io_term', 'repayment_type', 'interest_rate'];

    public $timestamps = false;

    function getApplicantLoanDetails($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('new_applicant_loans as al', 'applications.id', '=', 'al.application_id')
            ->select('al.*')
            ->where('leads.id', $lead_id)
            ->get();
        return $query;
    }
} 