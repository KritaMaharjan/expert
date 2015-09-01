<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmploymentDetails extends Model {

    protected $table = 'employment_details';
    protected $fillable = ['employment_type', 'job_title', 'starting_date', 'business_name', 'abn', 'contact_person', 'contact_person_job_title', 'contact_number', 'address_id', 'applicant_id', 'is_current'];

    public $timestamps = false;

    function getIncomeDetails($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('employment_details as e', 'aa.applicant_id', '=', 'e.applicant_id')
            ->join('employment_incomes as ei', 'aa.applicant_id', '=', 'ei.applicant_id')
            ->select('e.*','ei.*')
            ->where('leads.id', $lead_id);
        $result = $query->get();
        return $result;
    }
}