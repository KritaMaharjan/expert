<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LivingExpense extends Model {

    protected $table = 'living_expense';
    protected $fillable = ['monthly_living_expense', 'applicant_id'];

    public $timestamps = false;

    public function getExpenseDetails($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('living_expense as le', 'aa.applicant_id', '=', 'le.applicant_id')
            ->select('le.*')
            ->where('leads.id', $lead_id);
        $result = $query->get();
        return $result;
    }

}