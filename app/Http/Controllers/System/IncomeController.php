<?php
namespace App\Http\Controllers\System;

use App\Models\System\Application\EmploymentDetails;
use App\Models\System\Client\Client;
use App\Models\System\Application\Application;
use App\Models\System\Lead\Lead;
use Illuminate\Http\Request;
use App\Models\System\User;

class IncomeController extends BaseController {

    protected $client;
    protected $lead;
    protected $application;
    protected $property;
    protected $request;

    protected $rules = [
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
    ];

    public function __construct(Client $client, Application $application, EmploymentDetails $employment, Lead $lead, Request $request)
    {
        parent::__construct();
        $this->client = $client;
        $this->application = $application;
        $this->lead = $lead;
        $this->request = $request;
        $this->employment = $employment;
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

        $data['income_details'] = $income_details = $this->employment->getIncomeDetails($lead_id);
        $data['total_incomes'] = (count($income_details));
        $data['action'] = (empty($income_details))? 'add' : 'edit';
        $data['applicants'] = $this->getApplicantsArray($applicants);
        return view('system.application.income.main', $data);
    }

    function create()
    {
        $lead_id = $this->request->route('id');
        /*$validator = \Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();*/
        $this->employment->add($this->request->all(), $lead_id);
        return redirect()->route('system.application.expense', [$lead_id]);
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

    function template($lead_id)
    {
        $applicants = $this->lead->getLeadApplicants($lead_id);
        $data['applicants'] = $this->getApplicantsArray($applicants);
        $template = \View::make('system.application.income.add', $data)->render();
        return $this->success(['template' => $template]);
    }

}