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
        $applicants = $this->lead->getLeadApplicants($lead_id);
        $data['applicants'] = $this->getApplicantsArray($applicants);
        $prop_details = $this->property->getLeadPropertiesArray($lead_id);
        $data['properties'] = $this->getPropertiesArray($prop_details);
        $data['lead_details'] = $this->lead->getLeadDetails($lead_id);
        return view('system.application.loan', $data);
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

    function assign()
    {
        $application_id= $this->request->route('id');

        $data['application'] = Application::where('id', $application_id)->with('loan')->first();
        $sales_people = User::select('id', 'given_name', 'surname')->where('role', 4)->get()->toArray();
        $data['sales_people'][0] = 'Select user';
        foreach($sales_people as $sales_person)
        {
            $data['sales_people'][$sales_person['id']] = $sales_person['given_name'].' '. $sales_person['surname'];
        }

        return view('system.application.assign', $data);
    }

    function postAssign()
    {
        $validator = \Validator::make($this->request->all(), $this->assign_rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();
        $application_id= $this->request->route('id');
        $this->application->assign($this->request->all(), $application_id);

        \Flash::success('Application assigned successfully!');
        return redirect()->route('system.application');
    }

    function edit()
    {
        $application_id= $this->request->route('id');
        $data['application'] = Application::where('id', $application_id)->with('loan')->first();

        $users = User::select('id', 'email')->get()->toArray();
        $data['users'][0] = 'Select user';
        foreach($users as $user)
        {
            $data['users'][$user['id']] = $user['email'];
        }

        $clients = Client::select('id', 'preferred_name', 'given_name', 'surname')->get();
        $data['clients'][0] = 'Select Client';
        foreach($clients as $client)
        {
            $data['clients'][$client->id] = $client->preferred_name.' '.$client->given_name.' '.$client->surname;
        }

        return view('system.application.edit', $data);
    }

    function update()
    {
        $validator = \Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $application_id= $this->request->route('id');
        $this->application->edit($this->request->all(), $application_id);

        \Flash::success('Application updated successfully!');
        return redirect()->route('system.application');
    }

    function log()
    {
        $application_id = $this->request->route('id');

        //nested relationship
        $data['logs'] = Application::with('applicationlogs.log')->find($application_id);
        $users = User::select('id', 'email', 'given_name', 'surname')->get()->toArray();
        $data['users'][''] = 'Don\'t Email';
        foreach($users as $user)
        {
            $data['users'][$user['email']] = $user['given_name'].' '.$user['surname'];
        }
        return view('system.application.logs', $data);
    }

    function postLog()
    {
        $application_id = $this->request->route('id');
        $validator = \Validator::make($this->request->all(), [
            'comment' => 'required|max:255',
            'emailed_to' => 'email'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $application_id = $this->application->addLog($this->request->all(), $application_id);

        if($this->request->input('emailed_to') != '') {
            $mail = \EX::sendEmail($this->request->input('emailed_to'), '', 'email_log', ['{{LEAD_ID}}' => $application_id, '{{COMMENT}}' => $this->request->input('comment')]);
        }

        \Flash::success('Log added successfully!');
        return redirect()->back();
    }
    
    function delete()
    {
        $application_id = $this->request->route('id');
        $this->application->remove($application_id);

        return $this->success(['message' => 'Application deleted Successfully']);
    }

    function accept()
    {
        $application_id = $this->request->route('id');
        $this->application->accept($application_id);

        return $this->success(['message' => 'Application accepted Successfully']);
    }

    function view()
    {
        $application_id = $this->request->route('id');
        $data['application_details'] = $this->application->getApplicationDetails($application_id);
        return view('system.application.view', $data);
    }

    function deleteLog()
    {
        $log_id = $this->request->route('id');
        ApplicationLog::where('log_id', $log_id)->delete();
        Log::find($log_id)->delete();
        return $this->success(['message' => 'Log deleted Successfully']);
    }

}