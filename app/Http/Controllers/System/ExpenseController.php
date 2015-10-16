<?php
namespace App\Http\Controllers\System;

use App\Models\System\Application\LivingExpense;
use App\Models\System\Client\Client;
use App\Models\System\Application\Application;
use App\Models\System\Lead\Lead;
use Illuminate\Http\Request;
use App\Models\System\User;

class ExpenseController extends BaseController {

    protected $client;
    protected $lead;
    protected $application;
    protected $property;
    protected $request;

    public function __construct(Client $client, Application $application, Lead $lead, LivingExpense $expense, Request $request)
    {
        parent::__construct();
        $this->client = $client;
        $this->application = $application;
        $this->lead = $lead;
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
        $data['expense_details'] = $expense_details = $this->expense->getExpenseDetails($lead_id);
        $data['total_expenses'] = count($expense_details);
        $data['action'] = (empty($expense_details))? 'add' : 'edit';
        return view('system.application.expense.main', $data);
    }

    function create()
    {
        $lead_id = $this->request->route('id');
        /*$validator = \Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();*/

        $this->expense->add($this->request->all(), $lead_id);
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

    function template($lead_id)
    {
        $applicants = $this->lead->getLeadApplicants($lead_id);
        $data['applicants'] = $this->getApplicantsArray($applicants);
        $template = \View::make('system.application.expense.add', $data)->render();
        return $this->success(['template' => $template]);
    }
}