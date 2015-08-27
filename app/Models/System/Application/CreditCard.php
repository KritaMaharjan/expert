<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreditCard extends Model {

    protected $table = 'credit_cards';
    protected $fillable = ['ownership', 'type', 'to_be_cleared', 'lender', 'debit_from', 'limit', 'balance', 'applicant_id'];

    public $timestamps = false;

    function getLeadCardDetails($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('credit_cards as c', 'aa.applicant_id', '=', 'c.applicant_id')
            ->select('c.*')
            ->where('leads.id', $lead_id)
            ->get();
        return $query;
    }

}