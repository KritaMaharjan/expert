<?php
namespace App\Http\Controllers\System;

use App\Models\System\Application\Applicant;
use App\Models\System\Application\ApplicantAddress;
use App\Models\System\Application\Status;
use App\Models\System\Client\Client;
use App\Models\System\Application\Application;
use App\Models\System\Lead\Attachment;
use App\Models\System\Lead\Lead;
use App\Models\System\Log\ApplicationLog;
use App\Models\System\Log\Log;
use Illuminate\Http\Request;
use App\Models\System\User;
use Illuminate\Support\Facades\Input;

class ApplicationController extends BaseController {

    protected $client;
    protected $lead;
    protected $application;
    protected $request;

    protected $rules = [ 
        'given_name' => 'required|min:2|max:55|alpha',
        'surname' => 'required|min:2|max:55|alpha',
        'mother_maiden_name' => 'required|min:2|max:55|alpha',
        'email' => 'required|email',
        'dob' => 'required|date',
        'years_in_au' => 'required|numeric',
        'driver_licence_number' => 'numeric',
        'licence_expiry_date' => 'required|date',

        'mobile' => 'required|numeric',
        'home' => 'required|numeric',
        'work' => 'required|numeric',
        'fax' => 'numeric',

        'home_line1' => 'required|min:2',
        'home_line2' => 'required|min:2',
        'home_suburb' => 'required|min:2',
        'home_postcode' => 'required|min:2',
        'weekly_rent_expense' => 'required|numeric|min:2',
        'debit_from' => 'required|min:2',
        'live_there_since' => 'required|date',

        'postal_line1' => 'required|min:2',
        'postal_line2' => 'required|min:2',
        'postal_suburb' => 'required|min:2',
        'postal_postcode' => 'required|min:2',

        'job_title' => 'required|min:2',
        'starting_date' => 'required|date',
        'business_name' => 'required|min:2',
        'abn' => 'required|min:2',
        'contact_person' => 'required|min:2',
        'contact_person_job_title' => 'required|min:2',
        'contact_number' => 'required|min:2',
        'employment_line1' => 'required|min:2',
        'employment_line2' => 'required|min:2',
        'employment_suburb' => 'required|min:2',
        'employment_postcode' => 'required|min:2',
    ];

    protected $assign_rules = [
        'assign_to' => 'required|exists:ex_users,id'
    ];

    public function __construct(Client $client, Application $application,  Applicant $applicant, Lead $lead, Request $request)
    {
        parent::__construct();
        $this->client = $client;
        $this->application = $application;
        $this->lead = $lead;
        $this->request = $request;
        $this->applicant = $applicant;
    }

    function index()
    {
        return view('system.application.index');
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'date_created', 'ex_user_id', 'ex_lead_id', 'submitted'];
            $json = $this->application->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }

    function add()
    {
        $lead_id = $this->request->route('id');
        $data['applicants'] = $applicants = $this->lead->getLeadApplicantsDetails($lead_id);
        $data['total_applicants'] = $this->lead->getLeadApplicantsCount($lead_id);
        $data['action'] = (empty($applicants))? 'add' : 'edit';
        return view('system.application.applicant.main', $data);
    }

    function create()
    {
        $lead_id = $this->request->route('id');
        /*$validator = \Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();*/

        $application_id = $this->applicant->add($this->request->all(), $lead_id);
        if($application_id) {
            \Flash::success('Applicant added successfully!');
            return redirect()->route('system.application.property', [$lead_id]);
        }
    }

    function template($lead_id)
    {
        $data['applicants'] = $applicants = $this->lead->getLeadApplicantsDetails($lead_id);
        $data['total_applicants'] = $this->lead->getLeadApplicantsCount($lead_id);
        $template = \View::make('system.application.applicant.add', $data)->render();
        return $this->success(['template' => $template]);
    }

    function assign()
    {
        $application_id= $this->request->route('id');
        $data['application'] = $this->application->getApplicationDetails($application_id);
        //admin team
        $admin_team = User::select('id', 'given_name', 'surname')->where('role', 1)->get()->toArray();
        $data['admin_team'][''] = 'Choose Admin Team';
        foreach($admin_team as $sales_person)
        {
            $data['admin_team'][$sales_person['id']] = $sales_person['given_name'].' '. $sales_person['surname'];
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
    
    function delete()
    {
        $application_id = $this->request->route('id');
        $this->application->remove($application_id);

        \Flash::success('Application updated successfully!');
        return $this->success(['message' => 'Application deleted Successfully']);
    }

    function accept()
    {
        $application_id = $this->request->route('id');
        $this->application->accept($application_id);
        return $this->success(['message' => 'Application accepted Successfully']);
    }

    function decline()
    {
        $application_id = $this->request->route('id');
        $this->application->decline($application_id);
        return $this->success(['message' => 'Application declined Successfully']);
    }

    function view()
    {
        $application_id = $this->request->route('id');
        $data['application_details'] = $application_details = $this->application->getApplicationViewDetails($application_id);
        $data['attachment'] = Attachment::where('lead_id', $data['application_details']->lead->id)->first();
        $data['statuses'] = Status::lists('name', 'id');

        $completed = array();
        foreach($application_details->statuses as $key => $completed_stat)
        {
            $completed[$completed_stat->status_id]['id'] = $completed_stat->status_id;
            $completed[$completed_stat->status_id]['date_created'] = readable_date($completed_stat->date_created);
            $completed[$completed_stat->status_id]['updated_by'] = get_user_name($completed_stat->updated_by);
        }
        $data['completed'] = $completed;
        return view('system.application.overview.show', $data);
    }

    function changeStatus()
    {
        $application_id = $this->request->get('application_id');
        $status = $this->request->get('status');
        $this->application->changeStatus($application_id, $status);

        return $this->success(['message' => 'Application accepted Successfully']);
    }

    function deleteLog()
    {
        $log_id = $this->request->route('id');
        ApplicationLog::where('log_id', $log_id)->delete();
        Log::find($log_id)->delete();
        return $this->success(['message' => 'Log deleted Successfully']);
    }

    function pending()
    {
        return view('system.application.pending');
    }

    /* For accepted applications - Admin team*/
    function accepted()
    {
        return view('system.application.accepted');
    }

    public function acceptedDataJson()
    {
        if ($this->request->ajax()) {
            $json = $this->application->dataAcceptedTablePagination($this->request, $this->current_user()->id);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }
}