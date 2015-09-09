<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OtherIncome extends Model {

    protected $table = 'other_income';
    protected $fillable = ['applicant_id', 'type', 'credit_to', 'monthly_net_income'];

    public $timestamps = false;

    function getLeadIncomeDetails($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('other_income as o', 'aa.applicant_id', '=', 'o.applicant_id')
            ->select('o.*')
            ->where('leads.id', $lead_id)
            ->get();
        return $query;
    }
}