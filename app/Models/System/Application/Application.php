<?php
namespace App\Models\System\Application;

use App\Models\System\Lead\Lead;
use App\Models\System\Loan\CarLoan;
use App\Models\System\Loan\NewApplicantLoan;
use App\Models\System\Log\ApplicationLog;
use App\Models\System\Log\Log;
use App\Models\System\Profile\Addresses;
use App\Models\System\Profile\Phone;
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

    public function applicationLogs()
    {
        return $this->hasMany('App\Models\System\Log\ApplicationLog', 'application_id');
    }

    function add(array $request, $lead_id)
    {
        dd($request['age']);
        foreach ($request['title'] as $key => $title) {
            if ($request['dependent'][$key] == 'yes') {
                foreach ($request['age'][$key] as $ages) {
                    foreach ($ages as $age) {
                        if ($age != '')
                            echo $age . "<br/>";
                    }
                }
            }
        }
        DB::beginTransaction();

        try {
            $application_id = Application::select('id')->where('ex_leads_id', $lead_id)->first()->id;

            /* For each applicant */
            foreach ($request['title'] as $key => $title) {
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

                /* Contact Details */

                $mobile_phone = Phone::create([
                    'number' => $request['mobile'][$key],
                    'type' => 'mobile'
                ]);

                ApplicantPhone::create([
                    'phones_id' => $mobile_phone->id,
                    'applicants_id' => $applicant->id
                ]);

                $home_phone = Phone::create([
                    'number' => $request['home'][$key],
                    'type' => 'home'
                ]);

                ApplicantPhone::create([
                    'phones_id' => $home_phone->id,
                    'applicants_id' => $applicant->id
                ]);

                $work_phone = Phone::create([
                    'number' => $request['work'][$key],
                    'type' => 'work'
                ]);

                ApplicantPhone::create([
                    'phones_id' => $work_phone->id,
                    'applicants_id' => $applicant->id
                ]);

                /* Add code here for additional phones */

                /* Address Details */
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
                    'applicant_id' => $applicant->id,
                    'iscurrent' => 1,
                    'address_type_id' => 1, //1 home, 2 work, 3 postal
                    'live_there_since' => $request['live_there_since'][$key]
                ]);

                RentExpense::create([
                    'weekly_rent_expense' => $request['weekly_rent_expense'][$key],
                    'applicant_id' => $applicant->id,
                    'debit_from' => $request['debit_from'][$key]
                ]);

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
                    'applicant_id' => $applicant->id,
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
                    'applicant_id' => $applicant->id,
                    'iscurrent' => 0,
                    'address_type_id' => 1, //1 home, 2 work, 3 postal
                ]);

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
                    'applicant_id' => $applicant->id,
                    'is_current' => 0 //because ... previous. Its obvious
                ]);

                /* Dependent */
                if ($request['dependent'][$key] == 'yes') {
                    foreach ($request['age'][$key] as $ages) {
                        foreach ($ages as $age) {
                            if ($age != '')
                                Dependent::create([
                                    'age_of_dependents' => $age,
                                    'applicant_id' => $applicant->id
                                ]);
                        }
                    }
                }

            }
            //add logs for application addition
            $log = Log::create([
                'added_by' => \Auth::user()->id,
                'comment' => 'Application Created'
            ]);

            ApplicationLog::create([
                'application_id' => $application_id,
                'log_id' => $log->id
            ]);

            DB::commit();
            return $applicant->id;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
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

    /*
     *  Add Other Entities
     *  Input array
     * */
    function add_income(array $request, $lead_id)
    {
        DB::beginTransaction();

        try {
            if ($request['income'] == 1) {

                foreach ($request['car_applicant_id'] as $key => $applicant_id) {
                    $address = Addresses::create([
                        'line1' => $request['line1'][$key],
                        'line2' => $request['line2'][$key],
                        'suburb' => $request['suburb'][$key],
                        'state' => $request['state'][$key],
                        'postcode' => $request['postcode'][$key],
                        'country' => $request['country'][$key]
                    ]);

                    $employment = EmploymentDetails::create([
                        'employment_type' => $request['employment_type'][$key],
                        'job_title' => $request['job_title'][$key],
                        'starting_date' => $request['starting_date'][$key],
                        'business_name' => $request['business_name'][$key],
                        'abn' => $request['abn'][$key],
                        'contact_person' => $request['contact_person'][$key],
                        'contact_person_job_title' => $request['contact_person_job_title'][$key],
                        'contact_number' => $request['contact_number'][$key],
                        'address_id' => $address->id,
                        'is_current' => 1,
                        'applicant_id' => $applicant_id
                    ]);

                    if ($request['employment_type'][$key] == "Self Employed") {
                        $business_address = Addresses::create([
                            'line1' => $request['accountant_line1'][$key],
                            'line2' => $request['accountant_line2'][$key],
                            'suburb' => $request['accountant_suburb'][$key],
                            'state' => $request['accountant_state'][$key],
                            'postcode' => $request['accountant_postcode'][$key],
                            'country' => $request['accountant_country'][$key]
                        ]);

                        AccountantDetails::create([
                            'accountant_business_name' => $request['accountant_business_name'][$key],
                            'contact_person' => $request['accountant_contact_person'][$key],
                            'phone_number' => $request['accountant_phone_number'][$key],
                            'business_address_id' => $business_address->id,
                            'employment_details_id' => $employment->id
                        ]);
                    }

                    EmploymentIncome::create([
                        'annual_gross_income' => $request['annual_gross_income'][$key],
                        'pay_frequency' => $request['pay_frequency'][$key],
                        'salary_crediting' => $request['salary_crediting'][$key], //radio
                        'credit_to_where' => $request['credit_to_where'][$key],
                        'latest_pay_date' => $request['latest_pay_date'][$key],
                        'latest_payslip_period_from' => $request['latest_payslip_period_from'][$key],
                        'latest_payslip_period_to' => $request['latest_payslip_period_to'][$key],
                        'employment_detail_id' => $employment->id,
                        'applicant_id' => $applicant_id
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

    /*
     *  Add Expense sources
     *  Input array
     * */
    function add_expense(array $request, $lead_id)
    {
        DB::beginTransaction();

        try {
            if ($request['expense'] == 1) {

                foreach ($request['applicant_id'] as $key => $applicant_id) {
                    LivingExpense::create([
                        'monthly_living_expense' => $request['monthly_living_expense'][$key],
                        'applicant_id' => $applicant_id
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

        $data = $query->get();

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
        /* Create application */
        $application = Application::create([
            'date_created' => get_today_date(),
            'ex_user_id' => \Auth::user()->id,
            'ex_lead_id' => $lead_id,
            'submitted' => 0
        ]);

        DB::beginTransaction();
        try {
            foreach ($request['loan_purpose'] as $key => $loan_purpose) {
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
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }
} 