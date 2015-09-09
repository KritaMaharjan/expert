<?php
namespace App\Models\System\Property;

use App\Models\System\Loan\ExistingLoan;
use App\Models\System\Profile\Addresses;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Property extends Model
{

    protected $table = 'properties';
    protected $fillable = ['ownership', 'taken_as_security', 'market_value', 'address_id', 'property_usage', 'applicant_id', 'property_type', 'number_of_bedrooms', 'number_of_bathrooms', 'number_of_car_spaces', 'size', 'title_particulars', 'title_type'];

    public $timestamps = false;

    function add(array $request)
    {
        DB::beginTransaction();

        try {
            $address = Addresses::create([
                'line1' => $request['line1'],
                'line2' => $request['line2'],
                'suburb' => $request['suburb'],
                'state' => $request['state'],
                'postcode' => $request['postcode'],
                'country' => $request['country']
            ]);

            $property = Property::create([
                'taken_as_security' => $request['taken_as_security'],
                'market_value' => $request['market_value'],
                'property_usage' => $request['property_usage'],
                'applicant_id' => $request['applicant_id'],
                'property_type' => $request['property_type'],
                'number_of_bedrooms' => $request['number_of_bedrooms'],
                'number_of_bathrooms' => $request['number_of_bathrooms'],
                'number_of_car_spaces' => $request['number_of_car_spaces'],
                'size' => $request['size'],
                'title_particulars' => $request['title_particulars'],
                'title_type' => $request['title_type'],
                'address_id' => $address->id
            ]);

            ValuationAccess::create([
                'access_party' => $request['access_party'],
                'contact_person' => $request['contact_person'],
                'phone_number' => $request['phone_number'],
                'property_id' => $property->id
            ]);

            if($request['rental_income'] == 1) {
                Income::create([
                    'property_id' => $property->id,
                    'type' => 'property',
                    'weekly_rental' => $request['weekly_rental'],
                    'credit_to' => $request['credit_to']
                ]);
            };

            if($request['existing_loans'] == 1) {
                ExistingLoan::create([
                    'ownership' => $request['ownership'],
                    'to_be_cleared' => $request['to_be_cleared'],
                    'lender' => $request['lender'],
                    'loan_type' => $request['loan_type'],
                    'fixed_rate_term' => $request['fixed_rate_term'],
                    'fixed_rate_expiry_date' => $request['fixed_rate_expiry_date'],
                    'limit' => $request['limit'],
                    'balance' => $request['balance'],
                    'property_id' => $property->id
                ]);
            };


            $property->save();

            DB::commit();
            return $property->id;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    function getLeadPropertiesDetails($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('properties as p', 'aa.applicant_id', '=', 'p.applicant_id')
            ->join('addresses as address', 'address.id', '=', 'p.address_id')
            ->join('valuation_access as va', 'va.property_id', '=', 'p.id')
            ->select('p.*', 'p.id as property_id', 'address.*', 'va.*')
            ->where('leads.id', $lead_id)
            ->get();
        return $query;
    }

    function getRentalIncome($property_id)
    {
        $income = Income::where('property_id', $property_id)->first();
        return $income;
    }

    function getExistingLoans($property_id)
    {
        $loans = ExistingLoan::where('property_id', $property_id)->first();
        return $loans;
    }

    function getLeadPropertiesArray($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('properties as p', 'aa.applicant_id', '=', 'p.applicant_id')
            ->where('leads.id', $lead_id)
            ->select('p.id', 'p.property_type')
            ->orderBy('p.id', 'desc')
            ->lists('p.property_type', 'p.id');
        return $query;
    }

    function getPropertyAddress($applicant_id)
    {
        $query = DB::table('applicant_address as aa')
            ->join('addresses as a', 'a.id', '=', 'aa.address_id')
            ->join('address_types as t', 't.id', '=', 'aa.address_type_id')
            ->select('a.*', 'aa.address_type_id', 'aa.live_there_since', 'aa.iscurrent', 't.description as type')
            ->where('aa.applicant_id', $applicant_id);
        $result = $query->get();
        return $result;
    }

    function getLeadPropertiesCount($lead_id)
    {
        $query = DB::table('ex_leads as leads')
            ->join('applications', 'applications.ex_lead_id', '=', 'leads.id')
            ->join('application_applicants as aa', 'applications.id', '=', 'aa.application_id')
            ->join('properties as p', 'aa.applicant_id', '=', 'p.applicant_id')
            ->select('p.*')
            ->where('leads.id', $lead_id)
            ->count();
        return $query;
    }
} 