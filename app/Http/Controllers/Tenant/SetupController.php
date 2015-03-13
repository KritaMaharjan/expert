<?php 
namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Setting;
use App\Models\Tenant\User;
use App\Models\Tenant\PostalTown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Illuminate\Support\Facades\Validator;
use App\Fastbooks\Libraries\Tenant as Tenant;
use App\Fastbooks\Libraries\SetupChecker;
use Session;
use Config;

class SetupController extends BaseController {

	protected $setting;

    function __construct(Setting $setting, User $user, SetupChecker $setupChecker)
    {
    	\FB::can('Settings');
        parent::__construct();
        $this->setting = $setting;
        $this->user = $user;
        $this->setupChecker = $setupChecker;
    }

	public function getAbout()
	{
		$setup = $this->setupChecker->isFirstCompleted();
		if($setup)
			return tenant()->route('tenant.setup.business');
        $company = $this->setting->getCompany();
        $company_name= $company['company_name'];
		return view('tenant.auth.setup.about', compact('company_name'));
	}

	public function getBusiness()
	{
		$setup = $this->setupChecker->isSecondCompleted();
		if($setup)
			return tenant()->route('tenant.setup.fix');
		$countries = Config::get('tenant.countries');
		return view('tenant.auth.setup.business')->with('countries', $countries);
	}

	public function getFix()
	{
		return view('tenant.auth.setup.fix');
	}

	/*
	* Save first set up page
	*/
	public function saveAbout(Request $request)
	{
		$validator = Validator::make($request->all(),
		    array(
		    	'company_name' => 'required|between:5,35',
		    	'company_number' => 'required|min:5',
		    	'name' => 'required|between:2,30',
		    	'password' => 'required|between:5,25',
		    	'confirm_password' => 'required|same:password'
	    	)
		);

        if ($validator->fails())
        	return redirect()->back()->withErrors($validator)->withInput();

        $this->saveAboutDetails($request->except('_token'));
        //$this->setting->addOrUpdate($request->except('_token'));
        return tenant()->route('tenant.setup.business');
	}

	public function saveAboutDetails($details='')

	{ 

		$this->user->saveUser($this->current_user->email, array('fullname' => $details['name'], 'password' => $details['password'] ));

        $company_details = serialize([
        						'company_name'=>$details['company_name'],
								'company_number'=>$details['company_number']
							]);
        $this->setting->saveSetup('company', $company_details);
	}

	/*
	* Save second set up page
	*/
	public function saveBusiness(Request $request)
	{
		$validator = Validator::make($request->all(),
		    array(
		    	'entity_type' => 'required',
		    	'vat_reporting_rule' => 'required',
		    	'account_no' => 'required|between:2,15',
		    	'address' => 'required|between:2,50',
		    	'postal_code' => 'required|size:4',
		    	'town' => 'alpha|between:2,50',
		    	'country' => 'required|between:2,50'
		    	
	    	)
		);

        if ($validator->fails())
        	return redirect()->back()->withErrors($validator)->withInput();

        // $customer = Customer::firstOrNew([
        //     'postcode' => 


        // ]);

        $this->saveBusinessDetails($request->except('_token'));
        return tenant()->route('tenant.setup.fix');
	}

	public function saveBusinessDetails($details='')
	{
        $business_details = serialize([
        						'entity_type'=>$details['entity_type'],
						        'vat_reporting_rule'=>$details['vat_reporting_rule'],
						        'account_no'=>$details['account_no'],
						        'address'=>$details['address'],
						        'postal_code'=>$details['postal_code'],
						        'town'=>$details['town'],
						        'country'=>$details['country']
							]);
        $this->setting->saveSetup('business', $business_details);
	}

	/*
	* Save second set up page
	*/
	public function saveFix(Request $request)
	{
		$validator = Validator::make($request->all(),
		    array(
		    	'swift_num' => 'between:2,15',
		    	'iban_num' => 'between:2,15',

		    	'telephone' => 'numeric',

		    	'fax' => 'between:5,15',
		    	'website' => 'between:5,45',
		    	'service_email' => 'email|between:2,50',
		    	'logo' => 'image'
	    	)
		);

        if ($validator->fails())
        	return redirect()->back()->withErrors($validator)->withInput();

        $fileName = NULL;
        if (FacadeRequest::hasFile('logo'))
        {
	        $file = FacadeRequest::file('logo');
	        //$fileName = $this->uploadFile($file);
	        $fileName = \FB::uploadFile($file);
        }

        $this->saveFixDetails($request->except('_token'), $fileName);
        return tenant()->route('tenant.login');
	}

	public function saveFixDetails($details='', $fileName)
	{
        $business_details = serialize([
        						'swift_num'=>$details['swift_num'],
						        'iban_num'=>$details['iban_num'],
						        'telephone'=>$details['telephone'],
						        'fax'=>$details['fax'],
						        'website'=>$details['website'],
						        'service_email'=>$details['service_email'],
						        'logo'=>$fileName
							]);
        $this->setting->saveSetup('fix', $business_details);
	}

	public function getZipTown($postal_code) 
	{
		$postal_town = PostalTown::wherePostalCode($postal_code)->first();
		if($postal_town)
			$result = $postal_town->town;
		else
			$result = "";
		return \Response::json($result);  
    }

    public function getPostalCode()
    {
    	$postal_code = \Input::get('postcode');
    	$postal_towns = PostalTown::where('postcode', 'like', '%'.$postal_code.'%')->get();
    	if (!empty($postal_towns)) {
            foreach ($postal_towns as $res) {
                $postal_arr[] = $res->postal_code;
            }
        }
        return \Response::json($postal_arr);
    }

}