<?php
namespace App\Http\Controllers\System;

use App\Models\System\Application\EmploymentDetails;
use App\Models\System\Application\LivingExpense;
use App\Models\System\Client\Client;
use App\Models\System\Application\Application;
use App\Models\System\Lead\Lead;
use App\Models\System\Log\ApplicationLog;
use App\Models\System\Log\Log;
use App\Models\System\Property\Property;
use Illuminate\Http\Request;
use App\Models\System\User;

class OtherController extends BaseController {

    protected $client;
    protected $lead;
    protected $application;
    protected $property;
    protected $request;

    /*protected $rules = [
        'market_value' => 'required|numeric',
        'size' => 'required|numeric',
        'title_particulars' => 'required|min:2|max:55',
        'title_type' => 'required|min:2|max:55',
        'email' => 'required|email',

        'line1' => 'required|min:2',
        'line2' => 'required|min:2',
        'suburb' => 'required|min:2',
        'postcode' => 'required|min:2',

        'contact_person' => 'required|min:2',
        'phone_number' => 'required|min:2',

        'weekly_rental' => 'numeric',
        'credit_to' => 'min:2',

        'lender' => 'min:2',
        'balance' => 'numeric',
        'limit' => 'numeric',
    ];*/

    public function __construct(Client $client, Application $application, Lead $lead, Property $property, EmploymentDetails $employment, LivingExpense $expense, Request $request)
    {
        parent::__construct();
        $this->client = $client;
        $this->application = $application;
        $this->lead = $lead;
        $this->property = $property;
        $this->employment = $employment;
        $this->expense = $expense;
        $this->request = $request;
    }

    function add()
    {
        $lead_id = $this->request->route('id');
        $data['lead_details'] = $this->lead->getLeadDetails($lead_id);
        $applicants = $this->lead->getLeadApplicants($lead_id);

        if(empty($applicants)) {
            \Flash::error('No Applicants Found! Applicant should be added first to proceed');
            return redirect()->route('system.application.add', [$lead_id]);
        }

        $data['applicants'] = $this->getApplicantsArray($applicants);

        //for income
        $data['income_details'] = $income_details = $this->employment->getIncomeDetails($lead_id);
        $data['total_incomes'] = (count($income_details));
        $data['action'] = (empty($income_details))? 'add' : 'edit';

        //for expense
        $data['expense_details'] = $expense_details = $this->expense->getExpenseDetails($lead_id);
        $data['total_expenses'] = count($expense_details);
        $data['expense_action'] = (empty($expense_details))? 'add' : 'edit';

        return view('system.application.other', $data);
    }

    function create()
    {
        $lead_id = $this->request->route('id');
        /*$validator = \Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();*/

        $this->application->add_others($this->request->all(), $lead_id);

        return redirect()->route('system.application.review', [$lead_id]);
    }

    function getApplicantsArray($details)
    {
        $applicants = array();
        foreach($details as $detail)
        {
            $applicants[$detail->id] = $detail->given_name . ' ' . $detail->surname;
        }
        return $applicants;
    }

}