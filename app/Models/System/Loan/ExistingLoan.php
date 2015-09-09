<?php
namespace App\Models\System\Loan;

use Illuminate\Database\Eloquent\Model;

class ExistingLoan extends Model {

    protected $table = 'existing_loans';
    protected $fillable = ['ownership', 'for_property', 'to_be_cleared', 'lender', 'loan_type', 'fixed_rate_term', 'fixed_rate_expiry_date', 'limit', 'balance', 'property_id'];

    public $timestamps = false;
}