<?php
namespace App\Models\System\Application;

use App\Models\System\Application\ApplicationAssign;
use App\Models\System\Lead\Lead;
use App\Models\System\Lender\ApplicationLender;
use App\Models\System\Lender\Lender;
use App\Models\System\Loan\CarLoan;
use App\Models\System\Loan\NewApplicantLoan;
use App\Models\System\Log\ApplicationLog;
use App\Models\System\Log\Log;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Application extends Model
{

    protected $table = 'applications';
    protected $fillable = ['date_created', 'date_submitted', 'ex_user_id', 'ex_lead_id', 'reference', 'submitted'];
    public $timestamps = false;

    public function loan()
    {
        return $this->hasOne('App\Models\System\Loan\Loan', 'application_id');
    }

    public function assigned()
    {
        return $this->hasOne('App\Models\System\Application\ApplicationAssign', 'application_id');
    }

    public function lead()
    {
        return $this->belongsTo('App\Models\System\Lead\Lead', 'ex_lead_id');
    }

    //Application can have many logs
    public function logs()
    {
        return $this->hasMany('App\Models\System\Log\ApplicationLog', 'application_id');
    }

    public function statuses()
    {
        return $this->hasMany('App\Models\System\Application\ApplicationStatus', 'application_id');
    }

    function deleteApplicantDetails($lead_id)
    {
        /* Check if the applicant is used elsewhere */
    }

    /*
     *  Add Other Entities
     *  Input array
     * */
    function add_others(array $request, $lead_id)
    {
        DB::beginTransaction();

        try {
            if ($request['cars'] == 1) {

                foreach ($request['car_applicant_id'] as $key => $applicant_id) {
                    $car = Car::create([
                        'make_model' => $request['make_model'][$key],
                        'year_built' => $request['year_built'][$key],
                        'value' => $request['value'][$key],
                        'applicant_id' => $applicant_id
                    ]);

                    if (isset($request['car_loan'][$key]) && $request['car_loan'][$key] == 1) {
                        CarLoan::create([
                            'to_be_cleared' => $request['to_be_cleared'][$key],
                            'lender' => $request['lender'][$key],
                            'debit_from' => $request['debit_from'][$key],
                            'limit' => $request['limit'][$key],
                            'balance' => $request['balance'][$key],
                            'applicant_id' => $applicant_id
                        ]);
                    }
                }
            }

            if ($request['banks'] == 1) {
                foreach ($request['bank_applicant_id'] as $key => $applicant_id) {
                    BankAccount::create([
                        'bank' => $request['bank'][$key],
                        'balance' => $request['bank_balance'][$key],
                        'applicant_id' => $applicant_id
                    ]);
                }
            }

            if ($request['assets'] == 1) {
                foreach ($request['other_applicant_id'] as $key => $applicant_id) {
                    OtherAsset::create([
                        'applicant_id' => $applicant_id,
                        'type' => $request['other_type'][$key],
                        'value' => $request['other_value'][$key],
                        'home_content' => $request['home_content'][$key],
                        'superannuation' => $request['superannuation'][$key],
                        'deposit_paid' => $request['deposit_paid'][$key]
                    ]);
                }
            }

            if ($request['cards'] == 1) {
                foreach ($request['card_applicant_id'] as $key => $applicant_id) {
                    CreditCard::create([
                        'applicant_id' => $applicant_id,
                        'type' => $request['card_type'][$key],
                        'to_be_cleared' => $request['card_to_be_cleared'][$key],
                        'lender' => $request['card_lender'][$key],
                        'debit_from' => $request['card_debit_from'][$key],
                        'limit' => $request['card_limit'][$key],
                        'balance' => $request['card_balance'][$key]
                    ]);
                }
            }

            if ($request['incomes'] == 1) {
                foreach ($request['income_applicant_id'] as $key => $applicant_id) {
                    OtherIncome::create([
                        'applicant_id' => $applicant_id,
                        'type' => $request['income_type'][$key],
                        'credit_to' => $request['income_credit_to'][$key],
                        'monthly_net_income' => $request['monthly_net_income'][$key]
                    ]);
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

    /* *
     *  Display data for ajax pagination
     *  Output stdClass
     * */
    function dataTablePagination(Request $request, array $select = array())
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

        $query = $this->select($select);

        if ($orderColumn != '' AND $orderdir != '') {
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        /*if ($search != '') {
            $query = $query->where('domain', 'LIKE', "%$search%")->orwhere('email', 'LIKE', "%$search%");
        }*/
        $lead['total'] = $query->count();

        $query->skip($start)->take($take);

        $data = $query->groupBy('ex_lead_id')->get();

        foreach ($data as $key => &$value) {
            $value->created_by = get_user_name($value->ex_user_id);
            $value->status = ($value->submitted == 0) ? '<span class="label label-danger">No</span>' : '<span class="label label-success">Yes</span>';
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

    /* Add new loan for the lead */
    function add_loan(array $request, $lead_id)
    {
        DB::beginTransaction();
        try {
            /* Lead converted to application */
            $lead = Lead::find($lead_id);

            /* If application is not created before and this is the first time */
            if($lead->status != 2) {
                $lead->status = 2;
                $lead->save();

                /* Create application */
                $application = Application::create([
                    'date_created' => get_today_date(),
                    'ex_user_id' => \Auth::user()->id,
                    'ex_lead_id' => $lead_id,
                    'submitted' => 0
                ]);

                $this->changeStatus($application->id, 1);

                //add logs for application addition
                $log = Log::create([
                    'added_by' => \Auth::user()->id,
                    'comment' => 'Application Created'
                ]);

                ApplicationLog::create([
                    'application_id' => $application->id,
                    'log_id' => $log->id
                ]);
            } else {
                /* Delete removed loans */
                $application = Application::where('ex_lead_id', $lead_id)->first();
                if(isset($request['loan_id'])) {
                    $loan_ids = NewApplicantLoan::where('application_id', $application->id)->lists('id')->toArray();
                    $removed_loans = array_diff($loan_ids, $request['loan_id']);
                    NewApplicantLoan::whereIn('id', $removed_loans)->delete();
                }
            }

            foreach ($request['loan_purpose'] as $key => $loan_purpose) {
                if(!isset($request['loan_id'][$key])) {
                    NewApplicantLoan::create([
                        'application_id' => $application->id,
                        'amount' => $request['amount'][$key],
                        'loan_purpose' => $loan_purpose,
                        'deposit_paid' => $request['deposit_paid'][$key],
                        'settlement_date' => $request['settlement_date'][$key],
                        'loan_usage' => $request['loan_usage'][$key],
                        'total_loan_term' => $request['total_loan_term'][$key],
                        'loan_type' => $request['loan_type'][$key],
                        'fixed_rate_term' => $request['fixed_rate_term'][$key],
                        'repayment_type' => $request['repayment_type'][$key],
                        'io_term' => $request['io_term'][$key],
                        'interest_rate' => $request['interest_rate'][$key]
                    ]);
                }
                else {
                    $loan = NewApplicantLoan::find($request['loan_id'][$key]);
                    $loan->application_id = $application->id;
                    $loan->amount = $request['amount'][$key];
                    $loan->loan_purpose = $loan_purpose;
                    $loan->deposit_paid = $request['deposit_paid'][$key];
                    $loan->settlement_date = $request['settlement_date'][$key];
                    $loan->loan_usage = $request['loan_usage'][$key];
                    $loan->total_loan_term = $request['total_loan_term'][$key];
                    $loan->loan_type = $request['loan_type'][$key];
                    $loan->fixed_rate_term = $request['fixed_rate_term'][$key];
                    $loan->repayment_type = $request['repayment_type'][$key];
                    $loan->io_term = $request['io_term'][$key];
                    $loan->interest_rate = $request['interest_rate'][$key];
                    $loan->save();
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

    function getApplicationDetails($application_id)
    {
        $lead_id = Application::select('ex_lead_id')->find($application_id)->ex_lead_id;
        $lead = new Lead();
        $details = $lead->getLeadDetails($lead_id);
        return $details;
    }

    function getApplicationViewDetails($application_id)
    {
        $application = Application::with('lead', 'logs.log', 'statuses', 'assigned')->find($application_id);
        /*$application = DB::table('applications as app')
            ->join('ex_leads as leads', 'leads.id', '=', 'app.ex_lead_id')
            ->join('ex_clients as clients', 'leads.ex_clients_id', '=', 'clients.id')
            ->join('loans', 'loans.ex_leads_id', '=', 'leads.id')
            ->join('application_assign as assign', 'assign.application_id', '=', 'app.id')
            ->select('app.id', 'clients.given_name', 'clients.surname', 'loans.amount', 'loans.loan_type', 'app.ex_lead_id as leadId')
            ->where('app.id', $application_id)
            ->first();*/
        //dd($application->toArray());
        return $application;
    }

    /* Assign lead to admin person */
    function assign(array $request, $application_id)
    {
        DB::beginTransaction();

        try {
            $application = Application::find($application_id);

            ApplicationAssign::create([
                'description' => $request['description'],
                'assign_to' => $request['assign_to'],
                'application_id' => $application_id,
                'status' => 0,
                'assigned_date' => get_today_datetime(),
                'assigned_by' => \Auth::user()->id
            ]);

            $application->submitted = 1;
            $application->save();

            $this->changeStatus($application_id, 2);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    /* *
     *  Display data for ajax pagination of sales
     *  Output stdClass
     * */
    function pendingTablePagination(Request $request, array $select = array(), $user_id)
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

        $adminquery = DB::table('applications as app')
            ->join('ex_leads as leads', 'leads.id', '=', 'app.ex_lead_id')
            ->join('ex_clients as clients', 'leads.ex_clients_id', '=', 'clients.id')
            ->join('loans', 'loans.ex_leads_id', '=', 'leads.id')
            ->join('application_assign as assign', 'assign.application_id', '=', 'app.id')
            ->select('app.id', 'clients.given_name', 'clients.surname', 'loans.amount', 'loans.loan_type', 'app.ex_lead_id as leadId')
            ->where('app.submitted', 1)
            ->where('assign.status', 0)
            ->where('assign.assign_to', $user_id);
        $lead['total'] = $adminquery->count();

        $adminquery->skip($start)->take($take);

        $data = $adminquery->get();

        foreach ($data as $key => &$value) {
            $value->client_name = $value->given_name . " " . $value->surname;
            $value->type = $value->loan_type;
        }

        $lead['data'] = $data;
        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $lead['total'];
        $json->recordsFiltered = $lead['total'];
        $json->data = $lead['data'];

        return $json;
    }

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

        $adminquery = DB::table('applications as app')
            ->join('ex_leads as leads', 'leads.id', '=', 'app.ex_lead_id')
            ->join('ex_clients as clients', 'leads.ex_clients_id', '=', 'clients.id')
            ->join('loans', 'loans.ex_leads_id', '=', 'leads.id')
            ->join('application_assign as assign', 'assign.application_id', '=', 'app.id')
            ->select('app.id', 'clients.given_name', 'clients.surname', 'clients.email', 'loans.amount', 'loans.loan_type', 'app.ex_lead_id as leadId')
            ->where('app.submitted', 1)
            ->where('assign.status', 1)
            ->where('assign.assign_to', $user_id);

        $lead['total'] = $adminquery->count();

        $adminquery->skip($start)->take($take);

        $data = $adminquery->get();

        foreach ($data as $key => &$value) {
            $assigned_lender = ApplicationLender::where('application_id', $value->id)->first();
            if(empty($assigned_lender)) {
                $value->isAssigned = false;
                $value->assigned = "Not Assigned";
            }
            else {
                $value->isAssigned = false;
                $lender = Lender::select('company_name')->find($assigned_lender->lender_id);
                $value->assigned = $lender->company_name;
            }
            $value->client_name = $value->given_name . " " . $value->surname;
            $value->type = $value->loan_type;
        }

        $lead['data'] = $data;
        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $lead['total'];
        $json->recordsFiltered = $lead['total'];
        $json->data = $lead['data'];

        return $json;
    }

    /* Accept application by admin */
    function accept($application_id)
    {
        $application = ApplicationAssign::where(array('application_id' => $application_id, 'assign_to' => \Auth::user()->id))->first();
        $application->status = 1;
        $application->accepted_date = get_today_datetime();
        $application->save();

        $this->changeStatus($application_id, 3);
        $this->changeStatus($application_id, 3);
    }

    /* Accept application by admin */
    function decline($application_id)
    {
        $application = ApplicationAssign::where(array('application_id' => $application_id, 'assign_to' => \Auth::user()->id))->first();
        $application->status = 2;
        $application->save();
    }

    function changeStatus($application_id, $status)
    {
        ApplicationStatus::create([
            'status_id' => $status,
            'date_created' => get_today_datetime(),
            'application_id' => $application_id,
            'updated_by' => current_user_id()
        ]);
    }
} 