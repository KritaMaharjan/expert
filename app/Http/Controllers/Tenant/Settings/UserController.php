<?php 
namespace App\Http\Controllers\Tenant\Settings;

use App\Http\Controllers\Tenant\BaseController;
use App\Models\Tenant\Setting;
use App\Models\Tenant\User;
use App\Models\Tenant\Profile;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Illuminate\Support\Facades\Validator;
use Request as Requested;
use Illuminate\Http\Request;

class UserController extends BaseController {


	
     protected $setting;

    function __construct(Setting $setting)
    {
        \FB::can('Settings');
        parent::__construct();
        $this->setting = $setting;
    }

    public function index($value='')
    {
        
        $setting = $this->setting->getSetting();
    	$data = array('page_title' => 'User Controller','setting'=>$setting);
    	return view('tenant.setting.user')->with($data);
    }

    public function update(Request $request)
    {
             $validator = Validator::make($request->all(),
                                        array(
                                            'name' => 'required',
                                            'email' => 'required',
                                            'postcode' => 'required',
                                            'security_number' => 'required|numeric',
                                            'phone' => 'required|numeric',
                                            'address' => 'required',
                                            'comment' => 'required',
                                            'town' =>'required'
                                            )
                                        );

        if ($validator->fails())
            return  tenant()->route('tenant.edit.profile')->withErrors($validator)->withInput();

         //$all = $request->except('_token', 'group','photo');
            $group = $request->input('group');

                $fileName = NULL;
                if(FacadeRequest::hasFile('photo'))
                {
                    $file = FacadeRequest::file('photo');
                    $fileName = \FB::uploadFile($file);
                }

                $all_user =  array('name' => $request['name'], 
                                    'email'=> $request['email'], 
                                 );

                $all_profile = array(
                                    'security_number'=> $request['security_number'], 
                                    'postcode'=> $request['postcode'], 
                                    'phone'=> $request['phone'], 
                                    'address'=> $request['address'], 
                                    'comment'=> $request['comment'], 
                                    'image'=> $fileName,
                                    'tax' => $request['tax'],
                                    'town' => $request['town']
                                );

            if ($group != '') {
                $this->setting->addOrUpdate([$group => $all], $group);
            } else {
                $this->setting->addOrUpdate($all);
            }

              return tenant()->route('tenant.edit.profile')->with('message', 'Setting Updated successfully');

            
    }
}