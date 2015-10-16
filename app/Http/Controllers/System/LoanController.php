<?php
namespace App\Http\Controllers\System;

use App\Models\System\Client\Client;
use App\Models\System\Application\Application;
use App\Models\System\Lead\Lead;
use App\Models\System\Loan\NewApplicantLoan;
use App\Models\System\Property\Property;
use Illuminate\Http\Request;
use App\Models\System\User;

class LoanController extends BaseController {

    protected $client;
    protected $lead;
    protected $application;
    protected $request;

    public function __construct(Client $client, Application $application, Lead $lead, NewApplicantLoan $loan, Property $property, Request $request)
    {
        parent::__construct();
        $this->client = $client;
        $this->application = $application;
        $this->lead = $lead;
        $this->loan = $loan;
        $this->property = $property;
        $this->request = $request;
    }

    function index()
    {
        return view('system.application.loan');
    }

    function add()
    {
        $lead_id = $this->request->route('id');
        $data['loan_details'] = $loan_details = $this->loan->getApplicantLoanDetails($lead_id);
        $data['total_loans'] = count($data['loan_details']);
        $applicants = $this->lead->getLeadApplicants($lead_id);
        $data['applicants'] = $this->getApplicantsArray($applicants);
        $prop_details = $this->property->getLeadPropertiesArray($lead_id);
        $data['properties'] = $this->getPropertiesArray($prop_details);
        $data['lead_details'] = $this->lead->getLeadDetails($lead_id);
        $data['action'] = (empty($loan_details))? 'add' : 'edit';
        return view('system.application.loan.main', $data);
    }

    function template($lead_id)
    {
        $applicants = $this->lead->getLeadApplicants($lead_id);
        $data['applicants'] = $this->getApplicantsArray($applicants);
        $prop_details = $this->property->getLeadPropertiesArray($lead_id);
        $data['properties'] = $this->getPropertiesArray($prop_details);
        $template = \View::make('system.application.loan.add', $data)->render();
        return $this->success(['template' => $template]);
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

    function getPropertiesArray($details)
    {
        $properties = array();
        $count = 1;
        foreach($details as $key => $detail)
        {
            $properties[$key] = 'Property No. '.$count;
            $count++;
        }
        return $properties;
    }

    function create()
    {
        $lead_id = $this->request->route('id');
        /*$validator = \Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();*/

        $application_id = $this->application->add_loan($this->request->all(), $lead_id);
        if($application_id) {
            \Flash::success('Loan added successfully!');
        return redirect()->route('system.application.add', [$lead_id]);
        }
    }

}