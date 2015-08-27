<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Car extends Model {

    protected $table = 'cars';
    protected $fillable = ['make_model', 'year_built', 'value', 'applicant_id'];

    public $timestamps = false;

    function getLeadCarDetails($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('cars as c', 'aa.applicant_id', '=', 'c.applicant_id')
            ->select('c.*')
            ->where('leads.id', $lead_id)
            ->get();
        return $query;
    }
}