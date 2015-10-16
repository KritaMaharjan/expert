<?php
namespace App\Models\System\Property;

use App\Models\System\Lead\Lead;
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

    function add(array $request, $lead_id)
    {
        DB::beginTransaction();

        try {
            if($request['action'] == 'edit')
                $this->deleteRemoved($lead_id, $request['property_id']);

            foreach($request['applicant_id'] as $key => $applicant) {
                if(!isset($request['property_id'][$key])) {
                    $property_id = $this->addProperty($request, $key);
                } else {
                    $property_id = $request['property_id'][$key];
                    $this->editProperty($request, $key, $property_id);
                }
            }

            DB::commit();
            return $property_id;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    function addProperty($request, $key)
    {
        $address = Addresses::create([
            'line1' => $request['line1'][$key],
            'line2' => $request['line2'][$key],
            'suburb' => $request['suburb'][$key],
            'state' => $request['state'][$key],
            'postcode' => $request['postcode'][$key],
            'country' => $request['country'][$key]
        ]);

        $property = Property::create([
            'taken_as_security' => $request['taken_as_security'][$key],
            'market_value' => $request['market_value'][$key],
            'property_usage' => $request['property_usage'][$key],
            'applicant_id' => $request['applicant_id'][$key],
            'property_type' => $request['property_type'][$key],
            'number_of_bedrooms' => $request['number_of_bedrooms'][$key],
            'number_of_bathrooms' => $request['number_of_bathrooms'][$key],
            'number_of_car_spaces' => $request['number_of_car_spaces'][$key],
            'size' => $request['size'][$key],
            'title_particulars' => $request['title_particulars'][$key],
            'title_type' => $request['title_type'][$key],
            'address_id' => $address->id
        ]);

        ValuationAccess::create([
            'access_party' => $request['access_party'][$key],
            'contact_person' => $request['contact_person'][$key],
            'phone_number' => $request['phone_number'][$key],
            'property_id' => $property->id
        ]);

        if ($request['rental_income'][$key] == 1) {
            Income::create([
                'property_id' => $property->id,
                'type' => 'property',
                'weekly_rental' => $request['weekly_rental'][$key],
                'credit_to' => $request['credit_to'][$key]
            ]);
        };

        if ($request['existing_loans'][$key] == 1) {
            ExistingLoan::create([
                'ownership' => $request['ownership'][$key],
                'to_be_cleared' => $request['to_be_cleared'][$key],
                'lender' => $request['lender'][$key],
                'loan_type' => $request['loan_type'][$key],
                'fixed_rate_term' => $request['fixed_rate_term'][$key],
                'fixed_rate_expiry_date' => $request['fixed_rate_expiry_date'][$key],
                'limit' => $request['limit'][$key],
                'balance' => $request['balance'][$key],
                'property_id' => $property->id
            ]);
        };
        $property->save();
        return $property->id;
    }

    function editProperty($request, $key, $property_id)
    {
        $property = Property::find($property_id);
        $property->taken_as_security = $request['taken_as_security'][$key];
        $property->market_value = $request['market_value'][$key];
        $property->property_usage = $request['property_usage'][$key];
        $property->applicant_id = $request['applicant_id'][$key];
        $property->property_type = $request['property_type'][$key];
        $property->number_of_bedrooms = $request['number_of_bedrooms'][$key];
        $property->number_of_bathrooms = $request['number_of_bathrooms'][$key];
        $property->number_of_car_spaces = $request['number_of_car_spaces'][$key];
        $property->size = $request['size'][$key];
        $property->title_particulars = $request['title_particulars'][$key];
        $property->title_type = $request['title_type'][$key];
        $property->save();

        $this->editAddress($request, $property->address_id, $key);
        $this->editValuationAccess($request, $property->id, $key);
        $this->editIncome($request, $property->id, $key);
        $this->editLoan($request, $property->id, $key);
    }

    function editAddress($request, $id, $key)
    {
        $address = Addresses::find($id);
        $address->line1 = $request['line1'][$key];
        $address->line2 = $request['line2'][$key];
        $address->suburb = $request['suburb'][$key];
        $address->state = $request['state'][$key];
        $address->postcode = $request['postcode'][$key];
        $address->country = $request['country'][$key];
        $address->save();
    }

    function editValuationAccess($request, $property_id, $key)
    {
        $valuation = ValuationAccess::where('property_id', $property_id)->first();
        $valuation->access_party = $request['access_party'][$key];
        $valuation->contact_person = $request['contact_person'][$key];
        $valuation->phone_number = $request['phone_number'][$key];
        $valuation->save();
    }

    function editIncome($request, $property_id, $key)
    {
        Income::where('property_id', $property_id)->delete();
        if ($request['rental_income'][$key] == 1) {
            Income::create([
                'property_id' => $property_id,
                'type' => 'property',
                'weekly_rental' => $request['weekly_rental'][$key],
                'credit_to' => $request['credit_to'][$key]
            ]);
        }
    }

    function editLoan($request, $property_id, $key)
    {
        ExistingLoan::where('property_id', $property_id)->delete();
        if ($request['existing_loans'][$key] == 1) {
            ExistingLoan::create([
                'ownership' => $request['ownership'][$key],
                'to_be_cleared' => $request['to_be_cleared'][$key],
                'lender' => $request['lender'][$key],
                'loan_type' => $request['loan_type'][$key],
                'fixed_rate_term' => $request['fixed_rate_term'][$key],
                'fixed_rate_expiry_date' => $request['fixed_rate_expiry_date'][$key],
                'limit' => $request['limit'][$key],
                'balance' => $request['balance'][$key],
                'property_id' => $property_id
            ]);
        };
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

    function deleteRemoved($lead_id, $property_ids)
    {
        $lead = new Lead();
        $applicantIds = $lead->getLeadApplicantIds($lead_id);
        $old_ids = Property::whereIn('applicant_id', $applicantIds)->lists('id')->toArray();
        $removed_properties = array_diff($old_ids, $property_ids);

        ExistingLoan::whereIn('property_id', $removed_properties)->delete();
        Income::whereIn('property_id', $removed_properties)->delete();
        ValuationAccess::whereIn('property_id', $removed_properties)->delete();
        $props = Property::whereIn('id', $removed_properties);
        $removed_addresses = $props->lists('address_id')->toArray();
        $props->delete();
        Addresses::whereIn('id', $removed_addresses)->delete();
    }
} 