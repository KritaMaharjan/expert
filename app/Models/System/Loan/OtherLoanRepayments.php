<?php
namespace App\Models\System\Loan;

use Illuminate\Database\Eloquent\Model;

class OtherLoanRepayments extends Model {

    protected $table = 'new_loan_repayments';
    protected $fillable = ['monthly_repayment', 'new_applicant_loans_id'];

    public $timestamps = false;
}