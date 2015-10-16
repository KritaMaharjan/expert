<?php
namespace App\Http\Controllers\System;

use App\Models\System\Client\Client;
use App\Models\System\Application\Application;
use App\Models\System\Lead\Lead;
use App\Models\System\Property\Property;
use Illuminate\Http\Request;
use App\Models\System\User;

class PropertyController extends BaseController {

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

    public function __construct(Client $client, Application $application, Lead $lead, Property $property, Request $request)
    {
        parent::__construct();
        $this->client = $client;
        $this->application = $application;
        $this->lead = $lead;
        $this->property = $property;
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
        $properties = $this->property->getLeadPropertiesDetails($lead_id);
        foreach($properties as $key => $property)
        {
            $properties[$key]->income = $this->property->getRentalIncome($property->property_id);
            $properties[$key]->existing_loans = $this->property->getExistingLoans($property->property_id);
        }
        $data['properties'] = $properties;
        $data['total_properties'] = $this->property->getLeadPropertiesCount($lead_id);
        $data['action'] = (empty($properties))? 'add' : 'edit';
        return view('system.application.property.main', $data);
    }

    function template($lead_id)
    {
        $applicants = $this->lead->getLeadApplicants($lead_id);
        $data['applicants'] = $this->getApplicantsArray($applicants);
        $data['total_properties'] = $this->property->getLeadPropertiesCount($lead_id);
        $template = \View::make('system.application.property.add', $data)->render();
        return $this->success(['template' => $template]);
    }

    function create()
    {
        $lead_id = $this->request->route('id');
        /*$validator = \Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();*/

        $this->property->add($this->request->all(), $lead_id);
        \Flash::success('Property added successfully!');
        return redirect()->route('system.application.other', [$lead_id]);
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