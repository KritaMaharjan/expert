<?php
namespace App\Http\Controllers\System;

use App\Models\System\Application\Application;
use App\Models\System\Lead\Attachment;
use App\Models\System\Client\Client;
use App\Models\System\Lead\Lead;
use App\Models\System\Log\LeadLog;
use App\Models\System\Log\Log;
use Illuminate\Http\Request;
use App\Models\System\User;
use Illuminate\Support\Facades\Response;

class LeadController extends BaseController
{

    protected $client;
    protected $lead;
    protected $request;

    protected $rules = [
        'referral_notes' => 'required|min:2|max:55'
    ];

    protected $assign_rules = [
        'assign_to' => 'required|exists:ex_users,id',
        'meeting_datetime' => 'required',
        'meeting_place' => 'required|min:2|max:55'
    ];


    public function __construct(Client $client, Lead $lead, Request $request)
    {
        parent::__construct();
        $this->client = $client;
        $this->lead = $lead;
        $this->request = $request;
    }

    function index()
    {
        return view('system.lead.index');
    }

    /* For accepted lead - Sales */
    function accepted()
    {
        return view('system.lead.accepted');
    }

    function pending()
    {
        return view('system.lead.pending');
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'status', 'ex_clients_id', 'created_at'];
            $json = $this->lead->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }

    public function acceptedDataJson()
    {
        if ($this->request->ajax()) {
            $json = $this->lead->dataAcceptedTablePagination($this->request, $this->current_user()->id);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }

    function add()
    {
        $users = User::select('id', 'email', 'given_name', 'surname')->get()->toArray();
        $data['users'][''] = 'Select user';
        foreach ($users as $user) {
            $data['users'][$user['id']] = $user['given_name'] . ' ' . $user['surname'];
        }

        $clients = Client::select('id', 'preferred_name', 'given_name', 'surname')->get();
        $data['clients'][0] = 'Select Client';
        foreach ($clients as $client) {
            $data['clients'][$client->id] = $client->preferred_name . ' ' . $client->given_name . ' ' . $client->surname;
        }
        return view('system.lead.create', $data);
    }

    function create()
    {
        $validator = \Validator::make($this->request->all(), $this->rules);

        if ($this->request->input('ex_clients_id') == 0) {
            $this->rules['preferred_name'] = 'required|min:2|max:55';
            $this->rules['phone'] = 'required|min:2|numeric';
        }

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $lead_id = $this->lead->add($this->request->all());
        if ($lead_id) {
            if ($this->request->input('submit')) {
                \Flash::success('Lead added successfully!');
                return redirect()->route('system.lead');
            } else {
                return redirect()->route('system.lead.assign', [$lead_id]);
            }
        }
    }

    function assign()
    {
        $lead_id = $this->request->route('id');

        $data['lead'] = $this->lead->getLeadDetails($lead_id);
        $sales_people = User::select('id', 'given_name', 'surname')->where('role', 3)->get()->toArray();
        $data['sales_people'][0] = 'Select User';
        foreach ($sales_people as $sales_person) {
            if($sales_person['id'] != current_user_id())
                $data['sales_people'][$sales_person['id']] = $sales_person['given_name'] . ' ' . $sales_person['surname'];
            else
                $data['sales_people'][$sales_person['id']] = 'Assign to Self ('. $sales_person['given_name'] . ' ' . $sales_person['surname'].')';
        }

        return view('system.lead.assign', $data);
    }

    function postAssign()
    {
        $validator = \Validator::make($this->request->all(), $this->assign_rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();
        $lead_id = $this->request->route('id');
        $this->lead->assign($this->request->all(), $lead_id);

        \Flash::success('Lead assigned successfully!');
        return redirect()->route('system.lead');
    }

    function edit()
    {
        $lead_id = $this->request->route('id');
        $data['lead'] = Lead::where('id', $lead_id)->with('loan')->first();

        $users = User::select('id', 'email')->get()->toArray();
        $data['users'][0] = 'Select User';
        foreach ($users as $user) {
            $data['users'][$user['id']] = $user['email'];
        }

        $clients = Client::select('id', 'preferred_name', 'given_name', 'surname')->get();
        $data['clients'][0] = 'Select Client';
        foreach ($clients as $client) {
            $data['clients'][$client->id] = $client->preferred_name . ' ' . $client->given_name . ' ' . $client->surname;
        }

        return view('system.lead.edit', $data);
    }

    function update()
    {
        $validator = \Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $lead_id = $this->request->route('id');
        $this->lead->edit($this->request->all(), $lead_id);

        if ($this->request->input('submit')) {
            \Flash::success('Lead updated successfully!');
            return redirect()->route('system.lead');
        } else {
            return redirect()->route('system.lead.assign', [$lead_id]);
        }
    }

    function log()
    {
        $lead_id = $this->request->route('id');

        //nested relationship
        $data['logs'] = Lead::with('leadlogs.log')->find($lead_id);
        $users = User::select('id', 'email', 'given_name', 'surname')->get()->toArray();
        $data['users'][''] = 'Select User';
        foreach ($users as $user) {
            $data['users'][$user['email']] = $user['given_name'] . ' ' . $user['surname'];
        }
        return view('system.lead.logs', $data);
    }

    function postLog()
    {
        $lead_id = $this->request->route('id');
        $validator = \Validator::make($this->request->all(), [
            'comment' => 'required|max:255',
            'emailed_to' => 'email'
        ]);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $lead_id = $this->lead->addLog($this->request->all(), $lead_id);

        if ($this->request->input('emailed_to') != '') {
            $mail = \EX::sendEmail($this->request->input('emailed_to'), '', 'email_log', ['{{LEAD_ID}}' => $lead_id, '{{COMMENT}}' => $this->request->input('comment')]);
        }

        \Flash::success('Log added successfully!');
        return redirect()->back();
    }

    function delete()
    {
        $lead_id = $this->request->route('id');
        $this->lead->remove($lead_id);

        return $this->success(['message' => 'Lead deleted Successfully']);
    }

    function accept()
    {
        $lead_id = $this->request->route('id');
        $this->lead->accept($lead_id);

        return $this->success(['message' => 'Lead accepted Successfully']);
    }

    function decline()
    {
        $lead_id = $this->request->route('id');
        $this->lead->decline($lead_id);
        return $this->success(['message' => 'Lead declined Successfully']);
    }

    function view()
    {
        $users = User::select('id', 'email', 'given_name', 'surname')->get()->toArray();
        $data['users'][0] = 'Don\'t Email';
        foreach ($users as $user) {
            $data['users'][$user['id']] = $user['given_name'] . ' ' . $user['surname'];
        }
        $lead_id = $this->request->route('id');
        $data['logs'] = Lead::with('leadlogs.log')->find($lead_id);
        $data['lead_details'] = $this->lead->getLeadDetails($lead_id);
        $data['lead_status'] = $this->lead->getLeadStatus($lead_id);
        return view('system.lead.view', $data);
    }

    function attachment()
    {
        $lead_id = $this->request->route('id');
        $data['attachment'] = Attachment::where('lead_id', $lead_id)->first();
        return view('system.lead.attachment', $data);
    }

    function uploadAttachment()
    {
        $upload_rules = ['attachment' => 'required|mimes:doc,docx,pdf,txt,xls,xlsx'];
        $validator = \Validator::make($this->request->all(), $upload_rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $application_id = $this->request->route('id');
        if ($this->request->hasFile('attachment') AND $this->request->file('attachment')->isValid()) {
            $destinationPath = 'resources/uploads/attachments'; // upload path
            $extension = $this->request->file('attachment')->getClientOriginalExtension(); // get file extension
            $fileName = uniqid() . '_' . time() . '.' . $extension;
            $this->request->file('attachment')->move($destinationPath, $fileName);

            \Flash::success('File uploaded successfully!');
            $this->lead->uploadAttachment($application_id, $fileName);
            return redirect()->route('system.lead.accepted');
        } else {
            \Flash::danger('Uploaded file is not valid!');
            return redirect()->back();
        }
    }

    function downloadAttachment($id)
    {
        $attachment = Attachment::find($id);
        if(empty($attachment))
            abort(404);

        $filename = $attachment->filename;
        $file = public_path() . "/resources/uploads/attachments/".$filename;
        $headers = array(
            'Content-Type: application/pdf',
        );
        return Response::download($file);
    }

    function deleteLog()
    {
        $log_id = $this->request->route('id');
        LeadLog::where('log_id', $log_id)->delete();
        Log::find($log_id)->delete();
        return $this->success(['message' => 'Log deleted Successfully']);
    }

}