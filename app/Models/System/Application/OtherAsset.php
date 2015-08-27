<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OtherAsset extends Model {

    protected $table = 'other_assets';
    protected $fillable = ['type', 'value', 'home_content', 'superannuation', 'deposit_paid', 'applicant_id'];

    public $timestamps = false;

    function getLeadAssetsDetails($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('other_assets as o', 'aa.applicant_id', '=', 'o.applicant_id')
            ->select('o.*')
            ->where('leads.id', $lead_id)
            ->get();
        return $query;
    }
}