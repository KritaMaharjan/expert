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
    protected $setting;
	public function _construct(Profile $profile=NULL,Setting $setting)
	{
        \FB::can('Settings');
		parent::_construct();
		$this->profile = $profile;
        $this->setting = $setting;
	}


    public function index()
    {
        $profile = new Profile;
    	$smtp = $profile->getPersonalSetting($this->current_user->id);
    	$support_smtp = $profile->getSupportSetting();
      
    	$data = array('page_title' => 'Email Controller','smtp'=>$smtp,'support_smtp'=>$support_smtp);
    	return view('tenant.setting.email')->with($data);
    	//return view('tenant.setting.email');
    }

    function update(Request $request){
    	$all = $request->except('_token');
         $validator = \Validator::make($request->all(),
                                        array(
                                            'incoming_server' => 'required',
                                            'outgoing_server' => 'required',
                                            'email' => 'required',
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
								'email'=>$all['email'],
								'password'=>$all['password']
							]);
    	$flied = $request->input('group');

    	$profile = new Profile;
        $setting = new Setting;
        $user_id = $this->current_user->id;
       
        
        if($flied == 'support_smtp'){
            $all = $request->except('_token', 'group');
            $group = $request->input('group');
            $setting->addOrUpdate([$group => $all], $group);
        }else{
            $profile->updateprofile($user_id,$details,$flied);
        }
    	


        return \Response::json(array('status' => 'true', 'message' => 'Email Updated successfully'));

        }

    }
}