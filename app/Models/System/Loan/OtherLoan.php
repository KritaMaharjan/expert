<?php
namespace App\Models\System\Loan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OtherLoan extends Model
{

    protected $table = 'other_loans';
    protected $fillable = ['ownership', 'type', 'to_be_cleared', 'lender', 'limit', 'balance', 'applicant_id'];

    public $timestamps = false;
} 