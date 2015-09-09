<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class ApplicantLoan extends Model {

    protected $table = 'new_applicant_loans';
    protected $fillable = ['application_id', 'amount', 'for_property', 'secured_by', 'loan_purpose', 'deposit_paid', 'settlement_date', 'loan_usage', 'total_loan_term', 'loan_type', 'fixed_rate_term', 'io_term', 'repayment_type', 'interest_rate'];

    public $timestamps = false;

}