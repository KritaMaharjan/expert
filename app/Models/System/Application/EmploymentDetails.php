<?php
namespace App\Models\System\Application;

use App\Models\System\Lead\Lead;
use App\Models\System\Profile\Addresses;
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
            ->join('employment_incomes as ei', 'e.id', '=', 'ei.employment_detail_id')
            ->join('addresses as ad', 'ad.id', '=', 'e.address_id')
            ->select('e.id as income_id', 'e.*', 'ei.*', 'ad.*')
            ->where('leads.id', $lead_id);
        $result = $query->get();

        if(!empty($result))
        {
            foreach ($result as $key => $income)
            {
                $result[$key]->accountant_details = $this->getAccountantDetails($income->employment_detail_id);
            }
        }
        return $result;
    }

    /* Not all have accountants */
    function getAccountantDetails($employment_details_id)
    {
        $accountant = DB::table('accountant_details as ad')
            ->join('addresses as a', 'ad.business_address_id', '=', 'a.id')
            ->select('ad.id as accountant_id', 'a.id as accountant_address_id', 'a.*', 'ad.*')
            ->where('ad.employment_details_id', $employment_details_id);
        $result = $accountant->first();
        return $result;
    }

    /*
     *  Add Other Entities
     *  Input array
     * */
    function add(array $request, $lead_id)
    {
        DB::beginTransaction();
        try {
            if($request['action'] == 'edit')
                $this->deleteRemoved($lead_id, $request['income_id']);
            if ($request['income'] == 1) {
                foreach ($request['applicant_id'] as $key => $applicant_id) {
                    if(!isset($request['income_id'][$key])) {
                        $this->addDetails($request, $key);
                    } else {
                        $this->editDetails($request['income_id'][$key], $request, $key);
                    }
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    function addDetails($request, $key)
    {
        $address = Addresses::create([
            'line1' => $request['line1'][$key],
            'line2' => $request['line2'][$key],
            'suburb' => $request['suburb'][$key],
            'state' => $request['state'][$key],
            'postcode' => $request['postcode'][$key],
            'country' => $request['country'][$key]
        ]);

        $employment = EmploymentDetails::create([
            'employment_type' => $request['employment_type'][$key],
            'job_title' => $request['job_title'][$key],
            'starting_date' => $request['starting_date'][$key],
            'business_name' => $request['business_name'][$key],
            'abn' => $request['abn'][$key],
            'contact_person' => $request['contact_person'][$key],
            'contact_person_job_title' => $request['contact_person_job_title'][$key],
            'contact_number' => $request['contact_number'][$key],
            'address_id' => $address->id,
            'is_current' => 1,
            'applicant_id' => $request['applicant_id'][$key]
        ]);

        if ($request['employment_type'][$key] == "Self Employed") {
            $accountant = new AccountantDetails();
            $accountant->add($employment->id, $request, $key);
        }

        EmploymentIncome::create([
            'annual_gross_income' => $request['annual_gross_income'][$key],
            'pay_frequency' => $request['pay_frequency'][$key],
            'salary_crediting' => $request['salary_crediting'][$key], //radio
            'credit_to_where' => $request['credit_to_where'][$key],
            'latest_pay_date' => $request['latest_pay_date'][$key],
            'latest_payslip_period_from' => $request['latest_payslip_period_from'][$key],
            'latest_payslip_period_to' => $request['latest_payslip_period_to'][$key],
            'employment_detail_id' => $employment->id,
            'applicant_id' => $request['applicant_id'][$key]
        ]);
    }

    function editDetails($income_id, $request, $key)
    {
        $employment_id = $this->editEmploymentDetails($income_id, $request, $key);
        $this->editAccountantDetails($employment_id, $request, $key);
        $this->editEmploymentIncome($employment_id, $request, $key);
    }

    function editEmploymentDetails($income_id, $request, $key)
    {
        $employment = EmploymentDetails::find($income_id);
        $employment->employment_type = $request['employment_type'][$key];
        $employment->job_title = $request['job_title'][$key];
        $employment->starting_date = $request['starting_date'][$key];
        $employment->business_name = $request['business_name'][$key];
        $employment->abn = $request['abn'][$key];
        $employment->contact_person = $request['contact_person'][$key];
        $employment->contact_person_job_title = $request['contact_person_job_title'][$key];
        $employment->contact_number = $request['contact_number'][$key];
        $employment->is_current = 1;
        $employment->applicant_id = $request['applicant_id'][$key];
        $employment->save();
        $this->editEmploymentAddress($employment->address_id, $request, $key);

        return $employment->id;
    }

    function editEmploymentAddress($address_id, $request, $key)
    {
        $address = Addresses::find($address_id);
        $address->line1 = $request['line1'][$key];
        $address->line2 = $request['line2'][$key];
        $address->suburb = $request['suburb'][$key];
        $address->state = $request['state'][$key];
        $address->postcode = $request['postcode'][$key];
        $address->country = $request['country'][$key];
        $address->save();
    }

    function editAccountantDetails($employment_id, $request, $key)
    {
        $accountant_details = AccountantDetails::where('employment_details_id', $employment_id)->first();
        if ($request['employment_type'][$key] == "Self Employed" && !empty($accountant_details)) {
            $accountant_details->accountant_business_name = $request['accountant_business_name'][$key];
            $accountant_details->contact_person = $request['accountant_contact_person'][$key];
            $accountant_details->phone_number = $request['accountant_phone_number'][$key];
            $accountant_details->save();
            $this->editAccountantAddress($accountant_details->business_address_id, $request, $key);
        } elseif($request['employment_type'][$key] != "Self Employed" && !empty($accountant_details)) {
            $accountant_details->delete();
            Addresses::find($accountant_details->business_address_id)->delete();
        } else {
            $accountant = new AccountantDetails();
            $accountant->add($employment_id, $request, $key);
        }
    }

    function editAccountantAddress($address_id, $request, $key)
    {
        $business_address = Addresses::find($address_id);
        $business_address->line1 = $request['accountant_line1'][$key];
        $business_address->line2 = $request['accountant_line2'][$key];
        $business_address->suburb = $request['accountant_suburb'][$key];
        $business_address->state = $request['accountant_state'][$key];
        $business_address->postcode = $request['accountant_postcode'][$key];
        $business_address->country = $request['accountant_country'][$key];
        $business_address->save();
    }

    function editEmploymentIncome($employment_id, $request, $key)
    {
        $income = EmploymentIncome::firstOrCreate(['employment_detail_id' => $employment_id, 'applicant_id' => $request['applicant_id'][$key]]);
        $income->annual_gross_income = $request['annual_gross_income'][$key];
        $income->pay_frequency = $request['pay_frequency'][$key];
        $income->salary_crediting = $request['salary_crediting'][$key];
        $income->credit_to_where = $request['credit_to_where'][$key];
        $income->latest_pay_date = $request['latest_pay_date'][$key];
        $income->latest_payslip_period_from = $request['latest_payslip_period_from'][$key];
        $income->latest_payslip_period_to = $request['latest_payslip_period_to'][$key];
        $income->save();
    }

    function deleteRemoved($lead_id, $income_ids)
    {
        $lead = new Lead();
        $applicantIds = $lead->getLeadApplicantIds($lead_id);
        $old_ids= EmploymentDetails::whereIn('applicant_id', $applicantIds)->lists('id')->toArray();
        $removed_incomes = array_diff($old_ids, $income_ids);
        $addressIds= EmploymentDetails::whereIn('id', $removed_incomes)->lists('address_id')->toArray();

        $accountants = AccountantDetails::whereIn('employment_details_id', $removed_incomes);
        $accountant_address_ids = $accountants->lists('business_address_id')->toArray();
        $accountants->delete();
        Addresses::whereIn('id', $accountant_address_ids)->delete();

        EmploymentIncome::whereIn('employment_detail_id', $removed_incomes)->delete();

        EmploymentDetails::whereIn('id', $removed_incomes)->delete();
        Addresses::whereIn('id', $addressIds)->delete();
    }
}