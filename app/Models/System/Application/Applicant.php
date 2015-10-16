<?php
namespace App\Models\System\Application;
use App\Models\System\Profile\Addresses;
use App\Models\System\Profile\Phone;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model {

    protected $table = 'applicants';
    protected $fillable = ['preferred_name', 'title', 'given_name', 'surname', 'dob', 'residency_status', 'years_in_au', 'marital_status', 'email', 'mother_maiden_name', 'credit_card_issue', 'issue_comments', 'driver_licence_number', 'licence_state', 'licence_expiry_date'];

    public $timestamps = false;

    function add(array $request, $lead_id)
    {
        DB::beginTransaction();

        try {
            $application_id = Application::select('id')->where('ex_lead_id', $lead_id)->first()->id;

            /* For each applicant */
            foreach ($request['title'] as $key => $title) {
                if(!isset($request['applicant_id'][$key])) {
                    $applicant_id = $this->addApplicant($request, $key, $application_id);
                } else {
                    $applicant_id = $request['applicant_id'][$key];
                    $this->editApplicant($request, $key, $applicant_id);
                }

                /* Contact Details */
                $this->addPhoneDetails($request, $key, $applicant_id);

                /* Add code here for additional phones */

                /* Address Details */
                $this->addAddressDetails($request, $key, $applicant_id);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    function addApplicant($request, $key, $application_id)
    {
        $applicant = Applicant::create([
            'preferred_name' => 'app',
            'title' => $request['title'][$key],
            'given_name' => $request['given_name'][$key],
            'surname' => $request['surname'][$key],
            'dob' => $request['dob'][$key],
            'residency_status' => $request['residency_status'][$key],
            'years_in_au' => $request['years_in_au'][$key],
            'marital_status' => $request['marital_status'][$key],
            'email' => $request['email'][$key],
            'mother_maiden_name' => $request['mother_maiden_name'][$key],
            'credit_card_issue' => $request['credit_card_issue'][$key],
            'issue_comments' => $request['issue_comments'][$key],
            'driver_licence_number' => $request['driver_licence_number'][$key],
            'licence_state' => $request['licence_state'][$key],
            'licence_expiry_date' => $request['licence_expiry_date'][$key],
        ]);

        $application_applicant = ApplicationApplicant::create([
            'application_id' => $application_id,
            'applicant_id' => $applicant->id
        ]);
        return $applicant->id;
    }


    function editApplicant($request, $key, $applicant_id)
    {
        $applicant = Applicant::find($applicant_id);
        $applicant->preferred_name = 'app';
        $applicant->title = $request['title'][$key];
        $applicant->given_name = $request['given_name'][$key];
        $applicant->surname = $request['surname'][$key];
        $applicant->dob = $request['dob'][$key];
        $applicant->residency_status = $request['residency_status'][$key];
        $applicant->years_in_au = $request['years_in_au'][$key];
        $applicant->marital_status = $request['marital_status'][$key];
        $applicant->email = $request['email'][$key];
        $applicant->mother_maiden_name = $request['mother_maiden_name'][$key];
        $applicant->credit_card_issue = $request['credit_card_issue'][$key];
        $applicant->issue_comments = $request['issue_comments'][$key];
        $applicant->driver_licence_number = $request['driver_licence_number'][$key];
        $applicant->licence_state = $request['licence_state'][$key];
        $applicant->licence_expiry_date = $request['licence_expiry_date'][$key];
        $applicant->save();

        /* delete phone details */
        $this->deletePhoneDetails($applicant_id);

        /* delete phone details */
        $this->deleteAddressDetails($applicant_id);
    }

    function deletePhoneDetails($applicant_id)
    {
        $phones = ApplicantPhone::where('applicants_id', $applicant_id);
        $phone_ids = $phones->lists('phones_id');
        $phones->delete();
        Phone::whereIn('id', $phone_ids)->delete();
    }

    function deleteAddressDetails($applicant_id)
    {
        $addresses = ApplicantAddress::where('applicant_id', $applicant_id);
        $address_ids = $addresses->lists('address_id');
        $addresses->delete();
        Addresses::whereIn('id', $address_ids)->delete();
    }

    function addPhoneDetails($request, $key, $applicant_id)
    {
        //if(isset($request['mobile'][$key]) && $request['mobile'][$key] != null) { we need it for later in edit box
            $mobile_phone = Phone::create([
                'number' => $request['mobile'][$key],
                'type' => 'mobile'
            ]);

            ApplicantPhone::create([
                'phones_id' => $mobile_phone->id,
                'applicants_id' => $applicant_id
            ]);
        //}

        //if(isset($request['home'][$key]) && $request['home'][$key] != null) {
            $home_phone = Phone::create([
                'number' => $request['home'][$key],
                'type' => 'home'
            ]);

            ApplicantPhone::create([
                'phones_id' => $home_phone->id,
                'applicants_id' => $applicant_id
            ]);
        //}

        //if(isset($request['work'][$key]) && $request['work'][$key] != null) {
            $work_phone = Phone::create([
                'number' => $request['work'][$key],
                'type' => 'work'
            ]);

            ApplicantPhone::create([
                'phones_id' => $work_phone->id,
                'applicants_id' => $applicant_id
            ]);
        //}
    }

    function addAddressDetails($request, $key, $applicant_id)
    {
        $home_address = Addresses::create([
            'line1' => $request['home_line1'][$key],
            'line2' => $request['home_line2'][$key],
            'suburb' => $request['home_suburb'][$key],
            'state' => $request['home_state'][$key],
            'postcode' => $request['home_postcode'][$key],
            'country' => $request['home_country'][$key]
        ]);

        ApplicantAddress::create([
            'address_id' => $home_address->id,
            'applicant_id' => $applicant_id,
            'iscurrent' => 1,
            'address_type_id' => 1, //1 home, 2 work, 3 postal
            'live_there_since' => $request['live_there_since'][$key]
        ]);

        /*RentExpense::create([
            'weekly_rent_expense' => $request['weekly_rent_expense'][$key],
            'applicant_id' => $applicant_id,
            'debit_from' => $request['debit_from'][$key]
        ]);*/

        $postal_address = Addresses::create([
            'line1' => $request['postal_line1'][$key],
            'line2' => $request['postal_line2'][$key],
            'suburb' => $request['postal_suburb'][$key],
            'state' => $request['postal_state'][$key],
            'postcode' => $request['postal_postcode'][$key],
            'country' => $request['postal_country'][$key]
        ]);

        ApplicantAddress::create([
            'address_id' => $postal_address->id,
            'applicant_id' => $applicant_id,
            'iscurrent' => 0,
            'address_type_id' => 3, //1 home, 2 work, 3 postal
        ]);

        $previous_address = Addresses::create([
            'line1' => $request['previous_line1'][$key],
            'line2' => $request['previous_line2'][$key],
            'suburb' => $request['previous_suburb'][$key],
            'state' => $request['previous_state'][$key],
            'postcode' => $request['previous_postcode'][$key],
            'country' => $request['previous_country'][$key]
        ]);

        ApplicantAddress::create([
            'address_id' => $previous_address->id,
            'applicant_id' => $applicant_id,
            'iscurrent' => 0,
            'address_type_id' => 4, //1 home, 2 work, 3 postal, 4 previous
        ]);
    }

    function employment()
    {
        /*uncomment this after edit is cleared
                    $employment_address = Addresses::create([
                    'line1' => $request['employment_line1'][$key],
                    'line2' => $request['employment_line2'][$key],
                    'suburb' => $request['employment_suburb'][$key],
                    'state' => $request['employment_state'][$key],
                    'postcode' => $request['employment_postcode'][$key],
                    'country' => $request['employment_country'][$key]
                ]);

                EmploymentDetails::create([
                    'employment_type' => $request['employment_type'][$key],
                    'job_title' => $request['job_title'][$key],
                    'starting_date' => $request['starting_date'][$key],
                    'business_name' => $request['business_name'][$key],
                    'abn' => $request['abn'][$key],
                    'contact_person' => $request['contact_person'][$key],
                    'contact_person_job_title' => $request['contact_person_job_title'][$key],
                    'contact_number' => $request['contact_number'][$key],
                    'address_id' => $employment_address->id,
                    'applicant_id' => $applicant_id,
                    'is_current' => 0 //because ... previous. Its obvious
                ]);*/

        /* Dependent Uncomment this later */
        /*if ($request['dependent'][$key] == 'yes') {
            foreach ($request['age'][$key] as $ages) {
                foreach ($ages as $age) {
                    if ($age != '')
                        Dependent::create([
                            'age_of_dependents' => $age,
                            'applicant_id' => $applicant_id
                        ]);
                }
            }
        }*/
    }

}