<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BankAccount extends Model {

    protected $table = 'bank_accounts';
    protected $fillable = ['bank', 'balance', 'applicant_id'];

    public $timestamps = false;

    function getLeadBankDetails($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('bank_accounts as b', 'aa.applicant_id', '=', 'b.applicant_id')
            ->select('b.*')
            ->where('leads.id', $lead_id)
            ->get();
        return $query;
    }

}