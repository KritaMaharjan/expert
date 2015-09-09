<?php
namespace App\Models\System\Loan;
use Illuminate\Database\Eloquent\Model;

class CarLoanRepayment extends Model
{

    protected $table = 'car_loan_repayments';
    protected $fillable = ['car_loan_id', 'monthly_repayment'];

    public $timestamps = false;
} 