<?php
namespace App\Http\Controllers\System;

use App\Models\System\Client\Client;
use App\Models\System\Application\Application;
use App\Models\System\Lead\Lead;
use App\Models\System\Log\ApplicationLog;
use App\Models\System\Log\Log;
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
        $data['applicants'] = $this->getApplicantsArray($applicants);
        $data['total_properties'] = $this->property->getLeadPropertiesCount($lead_id);
        return view('system.application.property', $data);
    }

    function create()
    {
        $lead_id = $this->request->route('id');
        $validator = \Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->property->add($this->request->all(), $lead_id);
        \Flash::success('Applicant added successfully!');
        if($this->request->input('submit'))
            return redirect()->route('system.application.other', [$lead_id]);
        else
            return redirect()->route('system.application.property', [$lead_id]);
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