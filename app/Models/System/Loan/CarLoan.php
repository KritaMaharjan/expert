<?php
namespace App\Models\System\Loan;
use Illuminate\Database\Eloquent\Model;

class CarLoan extends Model
{

    protected $table = 'car_loans';
    protected $fillable = ['to_be_cleared', 'lender', 'debit_from', 'limit', 'balance', 'applicant_id'];

    public $timestamps = false;
} 