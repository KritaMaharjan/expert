<?php 
namespace App\Http\Controllers\Tenant\Settings;
use App\Http\Controllers\Tenant\BaseController;
use Illuminate\Support\Facades\Validator;
use Request as Requested;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Redirect;
use App\Models\Tenant\Setting;

class SystemController extends BaseController {

	 protected $setting;

    function __construct(Setting $setting)
    {
        \FB::can('Settings');
    	parent::__construct();
        $this->setting = $setting;
    }


    public function index($value='')
    {
    	$company = $this->setting->getCompany();
    	$business = $this->setting->getBusiness();
    	$fixit = $this->setting->getfix();
    
    	$data = array('countries' => \Config::get('tenant.countries'),'company'=>$company,'business'=>$business,'fix'=>$fixit);
    	return view('tenant.setting.system')->withPageTitle('System Controller')->with($data);
    }

    function update(Request $request)
    {

        if(!Requested::ajax()){
             $validator = Validator::make($request->all(),
                                        array(
                                            'company_name' => 'between:5,35',
                                            'company_number' => 'required|min:5',
                                            'entity_type' => '',
                                            'vat_reporting_rule' => '',
                                            'account_no' => 'between:2,15',
                                            'address' => 'between:2,50',
                                            'postal_code' => 'size:5',
                                            'town' => 'between:2,50',
                                            'country' => 'between:2,50',
                                            
                                            )
                                        );

        if ($validator->fails())
            return  redirect()->route('tenant.setting.system')->withErrors($validator)->withInput();
        
            $this->savebusiness($request);  
            return redirect()->route('tenant.setting.system')->with('message', 'Setting Updated successfully');
        }
        else
        {
            $this->savefix($request);    
        }   
    }

    public function savebusiness($request='')
    {
       

        $all = $request->except('_token', 'group','company_name','company_number');
        $group = 'business';
        $company = $request->only('company_name','company_number');
        $group_company = 'company';

        if ($group != '' ) {
            $this->setting->addOrUpdate([$group => $all], $group);
            $this->setting->addOrUpdate([$group_company => $company], $group_company);
        } else {
            $this->setting->addOrUpdate($all);
            $this->setting->addOrUpdate($company);
        }

        
    }

    public function savefix(Request $request)
    {
        

          $validator = Validator::make($request->all(),
                                                array(
                                                    'swift_num' => 'between:2,15',
                                                    'iban_num' => 'between:2,15',
                                                    'telephone' => 'between:2,15',
                                                    'fax' => 'between:5,15',
                                                    'website' => 'between:5,45',
                                                    'service_email' => 'email|between:2,50',
                                                    'logo' => 'image'
                                                    
                                                )
                                            );

      
            if($validator->fails())
            {
               
                return \Response::json(array('status' => 'false', 'errors' => $validator->getMessageBag()->toArray())); // 400 being the HTTP code for an invalid request.
            } else {


            $all = $request->except('_token', 'group');
            $group = $request->input('group');

            if($group == 'fix')
            {
                $fileName = NULL;
                if(FacadeRequest::hasFile('photo'))
                {
                    $file = FacadeRequest::file('photo');
                    $fileName = \FB::uploadFile($file);
                }
            }
             

            if ($group != '') {
                $this->setting->addOrUpdate([$group => $all], $group);
            } else {
                $this->setting->addOrUpdate($all);
            }

            return \Response::json(array('status' => 'true', 'message' => 'Setting Updated successfully'));
        }
    }
}