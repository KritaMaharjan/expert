<?php 
namespace App\Http\Controllers\Tenant\Settings;
use App\Http\Controllers\Tenant\BaseController;
use Illuminate\Support\Facades\Validator;
use Request as Requested;
use Illuminate\Http\Request;
use App\Models\Tenant\Profile;
use App\Models\Tenant\Setting;

class EmailController extends BaseController {

	protected $profile;
	public function _construct(Profile $profile=NULL)
	{
        \FB::can('Settings');
		parent::_construct();
		$this->profile = $profile;
	}


    public function index()
    {
        $profile = new Profile;
    	$personal_email_setting = $profile->getPersonalSetting($this->current_user->id);
    	$support_email_setting = $profile->getSupportSetting($this->current_user->id);
    	$data = array('page_title' => 'Email Controller','personal'=>$personal_email_setting,'support'=>$support_email_setting);
    	return view('tenant.setting.email')->with($data);
    	//return view('tenant.setting.email');
    }

    function update(Request $request){
    	$all = $request->except('_token');
         $validator = \Validator::make($request->all(),
                                        array(
                                            'incoming_server' => 'required',
                                            'outgoing_server' => 'required',
                                            'username' => 'required',
                                            'password' => 'required',
                                           
                                
                                            )
                                        );

        if ($validator->fails())
        {
            return \Response::json(array('status' => 'false', 'errors' => $validator->getMessageBag()->toArray()));
        } 
        else 
        {
    	$details = serialize([
        						'incoming_server'=>$all['incoming_server'],
								'outgoing_server'=>$all['outgoing_server'],
								'username'=>$all['username'],
								'password'=>$all['password']
							]);
    	$flied = $request->input('group');

    	$profile = new Profile;
        $user_id = $this->current_user->id;
       
        

    	$profile->updateprofile($user_id,$details,$flied);


        return \Response::json(array('status' => 'true', 'message' => 'Email Updated successfully'));

        }

    }
}