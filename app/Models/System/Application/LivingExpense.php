<?php
namespace App\Models\System\Application;

use App\Models\System\Lead\Lead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LivingExpense extends Model
{

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
            ->where('leads.id', $lead_id)
            ->orderBy('le.id');
        $result = $query->get();
        return $result;
    }

    /*
     *  Add Expense sources
     *  Input array
     * */
    function add(array $request, $lead_id)
    {
        if ($request['expense_action'] == 'edit')
            $this->deleteRemoved($lead_id, $request['expense_id']);

        if ($request['expense'] == 1) {
            foreach ($request['expense_applicant_id'] as $key => $applicant_id) {
                if (!isset($request['expense_id'][$key])) {
                    $this->addExpense($request['monthly_living_expense'][$key], $applicant_id);
                } else {
                    $this->editExpense($request['expense_id'][$key], $request['monthly_living_expense'][$key], $applicant_id);
                }
            }
        }
        return true;
    }

    function addExpense($monthly_living_key, $applicant_id)
    {
        LivingExpense::create([
            'monthly_living_expense' => $monthly_living_key,
            'applicant_id' => $applicant_id
        ]);
    }

    function editExpense($expense_id, $monthly_living_key, $applicant_id)
    {
        $living_expense = LivingExpense::find($expense_id);
        $living_expense->monthly_living_expense = $monthly_living_key;
        $living_expense->applicant_id = $applicant_id;
        $living_expense->save();
    }

    function deleteRemoved($lead_id, $expense_ids)
    {
        $lead = new Lead();
        $applicantIds = $lead->getLeadApplicantIds($lead_id);
        $old_ids = LivingExpense::whereIn('applicant_id', $applicantIds)->lists('id')->toArray();
        $removed_expenses = array_diff($old_ids, $expense_ids);
        LivingExpense::whereIn('id', $removed_expenses)->delete();
    }

}