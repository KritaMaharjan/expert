<?php
namespace App\Models\System\Lead;

use App\Models\System\Lead\Attachment;
use App\Models\System\Client\Client;
use App\Models\System\Client\ClientPhone;
use App\Models\System\Loan\Loan;
use App\Models\System\Log\LeadLog;
use App\Models\System\Log\Log;
use App\Models\System\Profile\Addresses;
use App\Models\System\Profile\Phone;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;

class Lead extends Model
{

    protected $table = 'ex_leads';
    protected $fillable = ['referral_notes', 'feedback', 'status', 'property_search_area', 'ex_clients_id', 'added_by_users_id'];

    public function loan()
    {
        return $this->hasOne('App\Models\System\Loan\Loan', 'ex_leads_id');
    }

    //Lead can have many attachments
    public function attachments()
    {
        return $this->hasMany('App\Models\System\Lead\Attachment', 'lead_id');
    }

    //Lead can have many logs
    public function leadlogs()
    {
        return $this->hasMany('App\Models\System\Log\LeadLog', 'ex_lead_id');
    }

    //assigned to a sales person
    public function salesAssign()
    {
        return $this->hasOne('App\Models\System\Lead\ClientLeadAssign', 'ex_leads_id');
    }

    //get client for the loan
    public function client()
    {
        return $this->belongsTo('App\Models\System\Client\Client', 'ex_clients_id');
    }

    //has one application
    public function application()
    {
        return $this->hasOne('App\Models\System\Application\Application', 'ex_leads_id');
    }

    function add(array $request)
    {
        DB::beginTransaction();

        try {

            if ($request['ex_clients_id'] == 0) {
                $client = Client::create([
                    'preferred_name' => $request['preferred_name'],
                    'title' => $request['title'],
                    'given_name' => $request['given_name'],
                    'surname' => $request['surname'],
                    'added_by_users_id' => \Auth::user()->id
                ]);

                $phone_number = $request['phone'];
                $phone = Phone::create([
                    'number' => $phone_number,
                    'type' => 'home'
                ]);

                ClientPhone::create([
                    'phones_id' => $phone->id,
                    'ex_clients_id' => $client->id,
                    'is_current' => 1
                ]);
                $client_id = $client->id;

            } else {
                $client_id = $request['ex_clients_id'];
            }

            $lead = Lead::create([
                'referral_notes' => $request['referral_notes'],
                'status' => 0, //0 unassigned 1 assigned
                'ex_clients_id' => $client_id,
                'added_by_users_id' => \Auth::user()->id
            ]);

            $loan = Loan::create([
                'loan_purpose' => $request['loan_purpose'],
                'loan_type' => $request['loan_type'],
                'ex_leads_id' => $lead->id
            ]);

            //add logs
            $log = Log::create([
                'added_by' => \Auth::user()->id,
                'comment' => 'Lead Created'
            ]);

            LeadLog::create([
                'ex_lead_id' => $lead->id,
                'log_id' => $log->id
            ]);

            DB::commit();
            return $lead->id;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    /* Assign lead to sales person */
    function assign(array $request, $lead_id)
    {
        DB::beginTransaction();

        try {
            $lead = Lead::find($lead_id);

            ClientLeadAssign::create([
                'ex_leads_id' => $lead_id,
                'meeting_datetime' => $request['meeting_datetime'],
                'meeting_place' => $request['meeting_place'],
                'description' => $request['description'],
                'assign_to' => $request['assign_to'],
                'status' => ($request['assign_to'] == current_user_id())? 1 : 0
            ]);

            $lead->status = 1;
            $lead->save();

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    function edit(array $request, $lead_id)
    {
        DB::beginTransaction();

        try {
            $lead = Lead::find($lead_id);

            $lead->referral_notes = $request['referral_notes'];
            /*$lead->feedback = $request['feedback'];
            $lead->property_search_area = $request['property_search_area'];*/
            $lead->ex_clients_id = $request['ex_clients_id'];

            $lead->save();

            $loan = Loan::where('ex_leads_id', $lead->id)->first();
            $loan->loan_purpose = $request['loan_purpose'];
            /*$loan->amount = $request['amount'];
            $loan->area = $request['area'];*/
            $loan->loan_type = $request['loan_type'];
            /*$loan->interest_rate = $request['interest_rate'];
            $loan->bank_name = $request['bank_name'];
            $loan->interest_type = $request['interest_type'];
            $loan->interest_date_till = $request['interest_date_till'];*/
            /*foreach($request['loan'] as $key => $loan_element) {
                $loan->$key = $loan_element;
            }*/
            $loan->save();
            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    /*
     * Delete lead
     * parameter lead id int
    */
    function remove($lead_id)
    {
        DB::beginTransaction();

        try {
            //get details
            $lead = Lead::find($lead_id);

            //loan details
            $loan_details = Loan::where('ex_leads_id', $lead_id)->first();

            //lead assign
            $lead_assign = ClientLeadAssign::where('ex_leads_id', $lead_id);
            $lead_assign->delete();
            $loan_details->delete();

            //logs
            $lead_logs = LeadLog::where('ex_lead_id', $lead_id)->get();
            $lead_logs->delete();

            foreach ($lead_logs as $lead_log) {
                $log = Log::find($lead_log->log_id);
                $log->delete();
            }

            $lead->delete();
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function getLeadDetails($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('ex_clients as clients', 'leads.ex_clients_id', '=', 'clients.id')
            ->join('loans', 'loans.ex_leads_id', '=', 'leads.id')
            ->select('leads.*', 'clients.given_name', 'clients.id as client_id', 'clients.preferred_name', 'clients.surname', 'clients.email', 'loans.loan_purpose', 'loans.amount', 'loans.loan_type', 'loans.bank_name', 'loans.area', 'loans.interest_rate', 'loans.interest_type', 'loans.interest_date_till')
            ->where('leads.id', $lead_id)
            ->first();
        $client = Client::find($query->client_id);
        $query->current_phone = (!empty($client) ? $client->currentPhone() : '');
        return $query;
    }

    function getLeadStatus($lead_id)
    {
        $lead = Lead::select('created_at', 'added_by_users_id', 'status')->find($lead_id);
        $status = array();
        $status['added_on']['date'] = format_datetime($lead->created_at);
        $status['added_on']['person'] = get_user_name($lead->added_by_users_id);

        $assign = ClientLeadAssign::select('assign_to', 'added_by_users_id', 'created_at', 'status')->where('ex_leads_id', $lead_id)->first();
        $status['assign']['date'] = (!empty($assign))? format_datetime($assign->created_at) : '';
        $status['assign']['person'] = (!empty($assign))? get_user_name($assign->added_by_users_id) : '';

        $status['received']['date'] = (!empty($assign) && $assign->status == 1)? format_datetime($assign->accepted_date) : '';
        $status['received']['person'] = (!empty($assign) && $assign->status == 1)? get_user_name($assign->assign_to) : '';
        return $status;
    }

    function getExpenseDetails($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('living_expense as le', 'aa.applicant_id', '=', 'le.applicant_id')
            ->select('le.*')
            ->where('leads.id', $lead_id);
        $result = $query->get();
        $result->count = $query->count();
        return $result;
    }

    function getLeadApplicants($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('applicants as a', 'aa.applicant_id', '=', 'a.id')
            ->select('a.*')
            ->where('leads.id', $lead_id);
        $result = $query->get();
        return $result;
    }

    function getLeadApplicantIds($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->select('aa.applicant_id')
            ->where('leads.id', $lead_id);
        $result = $query->lists('aa.applicant_id');
        return $result;
    }

    function getLeadApplicantsDetails($lead_id)
    {
        $result = $this->getLeadApplicants($lead_id);

        foreach ($result as $key => $applicant) {
            $result[$key]->address = $this->getApplicantAddress($applicant->id);
            $result[$key]->phone = $this->getApplicantPhone($applicant->id);
        }
        return $result;
    }

    function getApplicantAddress($applicant_id)
    {
        $query = DB::table('applicant_address as aa')
            ->join('addresses as a', 'a.id', '=', 'aa.address_id')
            ->join('address_types as t', 't.id', '=', 'aa.address_type_id')
            ->select('a.*', 'aa.address_type_id', 'aa.live_there_since', 'aa.iscurrent', 't.description as type')
            ->where('aa.applicant_id', $applicant_id);
        $result = $query->get();
        return $result;
    }

    function getApplicantPhone($applicant_id)
    {
        $query = DB::table('applicant_phone as ap')
            ->join('phones as p', 'p.id', '=', 'ap.phones_id')
            ->select('p.*')
            ->where('ap.applicants_id', $applicant_id);
        $result = $query->get();
        return $result;
    }

    function getLeadApplicantsCount($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('applicants as a', 'aa.applicant_id', '=', 'a.id')
            ->select('a.*')
            ->where('leads.id', $lead_id)
            ->count();
        return $query;
    }

    /* Upload Attachment */
    function uploadAttachment($lead_id, $fileName)
    {
        //check if other attachment still exists
        $attachment = Attachment::where('lead_id', $lead_id)->first();
        if(!empty($attachment)) {
            //delete file if exists
            $destinationPath = 'resources/uploads/attachments/'; // upload path
            unlink($destinationPath.$attachment->filename);
            $attachment->filename = $fileName;
            $attachment->uploaded_date = get_today_datetime();
            $attachment->added_by_users_id = \Auth::user()->id;
            $attachment->save();
        } else {

            Attachment::create([
                'filename' => $fileName,
                'lead_id' => $lead_id,
                'uploaded_date' => get_today_datetime(),
                'added_by_users_id' => \Auth::user()->id
            ]);
        }
    }

    /* *
     *  Display data for ajax pagination of sales
     *  Output stdClass
     * */
    function dataSalesTablePagination(Request $request, array $select = array(), $user_id)
    {
        if ((is_array($select) AND count($select) < 1)) {
            $select = "*";
        }
        $take = ($request->input('length') > 0) ? $request->input('length') : 10;
        $start = ($request->input('start') > 0) ? $request->input('start') : 0;

        $search = $request->input('search');
        $search = $search['value'];
        $order = $request->input('order');
        $column_id = $order[0]['column'];
        $columns = $request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $lead = array();

        //$query = $this->select($select)->with('loan', 'salesAssign')->first();

        $salesquery = DB::table('ex_leads as leads')
            ->join('ex_clients as clients', 'leads.ex_clients_id', '=', 'clients.id')
            ->join('loans', 'loans.ex_leads_id', '=', 'leads.id')
            ->join('ex_client_leads_assign as assign', 'assign.ex_leads_id', '=', 'leads.id')
            ->select('leads.id', 'clients.given_name', 'clients.surname', 'loans.amount', 'loans.loan_type', 'assign.meeting_datetime', 'assign.meeting_place')
            ->where('leads.status', 1)
            ->where('assign.status', 0)
            ->where('assign.assign_to', $user_id);

        /*$salesquery = $this->where('status', 1)->with([
            'salesAssign' => function($salesquery2)
            {
                $salesquery2->where('assign_to', 2); // get only assigned to self change this later
                $salesquery2->where('status', 0); // get only assigned to self change this later
            },
            'client' => function($salesquery2)
            {
                $salesquery2->select('id', 'given_name', 'surname');
            }, 'loan']);*/

        /*if ($search != '') {
            $salesquery = $salesquery->where('domain', 'LIKE', "%$search%")->orwhere('email', 'LIKE', "%$search%");
        }*/
        $lead['total'] = $salesquery->count();

        $salesquery->skip($start)->take($take);

        $data = $salesquery->get();

        foreach ($data as $key => &$value) {
            $value->client_name = $value->given_name . " " . $value->surname;
            //$value->amount = $value->amount;
            $value->meeting_time = format_datetime($value->meeting_datetime);
            //$value->meeting_place = $value->meeting_place;
        }

        $lead['data'] = $data;
        //$lead['data'] = $data->toArray();
        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $lead['total'];
        $json->recordsFiltered = $lead['total'];
        $json->data = $lead['data'];

        return $json;
    }

    /* *
     *  Display data for ajax pagination of accepted leads
     *  Output stdClass
     * */
    function dataAcceptedTablePagination(Request $request, $user_id)
    {
        $take = ($request->input('length') > 0) ? $request->input('length') : 10;
        $start = ($request->input('start') > 0) ? $request->input('start') : 0;

        $search = $request->input('search');
        $search = $search['value'];
        $order = $request->input('order');
        $column_id = $order[0]['column'];
        $columns = $request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $lead = array();

        $salesquery = DB::table('ex_leads as leads')
            ->join('ex_clients as clients', 'leads.ex_clients_id', '=', 'clients.id')
            ->join('loans', 'loans.ex_leads_id', '=', 'leads.id')
            ->join('ex_client_leads_assign as assign', 'assign.ex_leads_id', '=', 'leads.id')
            ->select('leads.id', 'clients.given_name', 'clients.email', 'clients.surname', 'loans.amount', 'loans.loan_type', 'assign.meeting_datetime', 'assign.meeting_place')
            ->where('leads.status', 1)
            ->where('assign.status', 1)
            ->where('assign.assign_to', $user_id);

        $lead['total'] = $salesquery->count();

        $salesquery->skip($start)->take($take);

        $data = $salesquery->get();

        foreach ($data as $key => &$value) {
            $value->client_name = $value->given_name . " " . $value->surname;
            $value->meeting_datetime = format_datetime($value->meeting_datetime);
        }

        $lead['data'] = $data;
        //$lead['data'] = $data->toArray();
        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $lead['total'];
        $json->recordsFiltered = $lead['total'];
        $json->data = $lead['data'];

        return $json;
    }

    /* *
     *  Display data for ajax pagination
     *  Output stdClass
     * */
    function dataTablePagination(Request $request, array $select = array(), $unassigned_only = false)
    {
        if ((is_array($select) AND count($select) < 1)) {
            $select = "*";
        }
        $take = ($request->input('length') > 0) ? $request->input('length') : 10;
        $start = ($request->input('start') > 0) ? $request->input('start') : 0;

        $search = $request->input('search');
        $search = $search['value'];
        $order = $request->input('order');
        $column_id = $order[0]['column'];
        $columns = $request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $lead = array();

        $query = $this->select($select)->with('loan')->first();

        if ($orderColumn != '' AND $orderdir != '') {
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        if ($search != '') {
            $query = $query->where('domain', 'LIKE', "%$search%")->orwhere('email', 'LIKE', "%$search%");
        }

        if(!current_user()->isSuperAdmin)
            $query = $query->where('added_by_users_id', current_user_id());

        $lead['total'] = $query->count();

        $query->skip($start)->take($take);

        if ($unassigned_only == true)
            $query = $query->where('status', 0);

        $data = $query->get();

        foreach ($data as $key => &$value) {
            $client = Client::find($value->ex_clients_id);

            if ($value->status == 1) {
                $meeting_date = ClientLeadAssign::where('ex_leads_id', $value->id)->first()->meeting_datetime;
                $meeting_date = format_datetime($meeting_date);
            } else
                $meeting_date = "Not Assigned Yet <a class = 'btn btn-primary btn-xs' href =".url('system/lead/assign', $value->id).">Assign Now</a>";

            $phone_number = $client->currentPhone();
            $value->client = $client->given_name . " " . $client->surname;
            $value->preferred_name = $client->preferred_name;
            $value->phone_number = $phone_number;
            $value->loan_type = $value->loan->loan_type;
            $value->meeting_date = $meeting_date;
            $value->actual_status = $value->status;
            $value->amount = $value->loan->amount;
            $value->status = ($value->status == 0) ? '<span class="label label-danger">Unassigned</span>' : '<span class="label label-success">Assigned</span>';
        }
        $lead['data'] = $data->toArray();
        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $lead['total'];
        $json->recordsFiltered = $lead['total'];
        $json->data = $lead['data'];

        return $json;
    }

    function toData()
    {
        $this->show_url = '';// tenant()->url('client/' . $this->id);
        $this->edit_url = '';//tenant()->url('client/' . $this->id . '/edit');
        return $this->toArray();
    }

    /* Add log details to a lead */
    function addLog(array $request, $lead_id)
    {
        DB::beginTransaction();
        try {

            $log = Log::create([
                'added_by' => \Auth::user()->id,
                'comment' => $request['comment'],
                'emailed_to' => $request['emailed_to'],
                'email' => ($request['emailed_to'] == '') ? 0 : 1,
            ]);

            LeadLog::create([
                'ex_lead_id' => $lead_id,
                'log_id' => $log->id
            ]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    /* Accept lead by sales person */
    function accept($lead_id)
    {
        $lead = ClientLeadAssign::where(array('ex_leads_id' => $lead_id, 'assign_to' => \Auth::user()->id))->first();
        $lead->status = 1;
        $lead->save();
    }

    /* Declined lead by sales person */
    function decline($lead_id)
    {
        $lead = ClientLeadAssign::where(array('ex_leads_id' => $lead_id, 'assign_to' => \Auth::user()->id))->first();
        $lead->status = 2;
        $lead->save();
    }
} 