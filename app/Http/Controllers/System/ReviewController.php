<?php
namespace App\Http\Controllers\System;

use App\Models\System\Application\BankAccount;
use App\Models\System\Application\Car;
use App\Models\System\Application\CreditCard;
use App\Models\System\Application\EmploymentDetails;
use App\Models\System\Application\LivingExpense;
use App\Models\System\Application\OtherAsset;
use App\Models\System\Application\OtherIncome;
use App\Models\System\Client\Client;
use App\Models\System\Application\Application;
use App\Models\System\Lead\Lead;
use App\Models\System\Property\Property;
use Illuminate\Http\Request;
use App\Models\System\User;

class ReviewController extends BaseController {

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

    public function __construct(Client $client, Application $application, Property $property, Lead $lead, Request $request, Car $car, BankAccount $bankAccount, OtherAsset $otherAssets, CreditCard $cards, OtherIncome $otherIncome, EmploymentDetails $employment, LivingExpense $expense)
    {
        parent::__construct();
        $this->client = $client;
        $this->application = $application;
        $this->property = $property;
        $this->lead = $lead;
        $this->car = $car;
        $this->bankAccount = $bankAccount;
        $this->otherAssets = $otherAssets;
        $this->cards = $cards;
        $this->otherIncome = $otherIncome;
        $this->employment = $employment;
        $this->expense = $expense;
        $this->request = $request;
    }

    function index()
    {
        $lead_id = $this->request->route('id');
        $data['lead_details'] = $this->lead->getLeadDetails($lead_id);
        $applicants = $data['applicant_details'] = $this->lead->getLeadApplicantsDetails($lead_id);
        $data['property_details'] = $this->property->getLeadPropertiesDetails($lead_id);
        $data['car_details'] = $this->car->getLeadCarDetails($lead_id);
        $data['bank_details'] = $this->bankAccount->getLeadBankDetails($lead_id);
        $data['other_details'] = $this->otherAssets->getLeadAssetsDetails($lead_id);
        $data['card_details'] = $this->cards->getLeadCardDetails($lead_id);
        $data['other_income_details'] = $this->otherIncome->getLeadIncomeDetails($lead_id);
        $data['income_details'] = $this->employment->getIncomeDetails($lead_id);
        $data['expense_details'] = $this->expense->getExpenseDetails($lead_id);
        $data['applicants'] = $this->getApplicantsArray($applicants);
        return view('system.application.review', $data);
    }

    function add()
    {
        $lead_id = $this->request->route('id');
        $data['lead_details'] = $this->lead->getLeadDetails($lead_id);
        $applicants = $this->lead->getLeadApplicants($lead_id);
        $data['applicants'] = $this->getApplicantsArray($applicants);
        return view('system.application.expense', $data);
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