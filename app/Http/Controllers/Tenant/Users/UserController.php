<?php 
namespace App\Http\Controllers\Tenant\Users;
use App\Http\Controllers\Tenant\BaseController;
use Illuminate\Support\Facades\Request as FacadeRequest;
use App\Models\Tenant\User;
use App\Models\Tenant\Profile;
use Illuminate\Http\Request;

class UserController extends BaseController {

    protected $request;
    protected $user;

    protected $rules = array(
                'fullname' => 'required|between:2,30',
                'email' => 'required|email',

                'phone' => 'numeric',

                'address' => 'required|between:2,50',
                'postcode' => 'required|size:4',
                'town' => 'alpha|between:2,50',
                'social_security_number' => 'required|size:5',
                //'photo' => 'image',
                'incoming_server' => 'min:8|required_with:outgoing_server,email_username,email_password',
                'outgoing_server' => 'min:8|required_with:incoming_server,email_username,email_password',
                'email_username' => 'min:5|required_with:incoming_server,outgoing_server,email_password',
                'email_password' => 'min:5|required_with:incoming_server,outgoing_server,email_username',
            );

	public function __construct(User $user, Request $request)
	{
        \FB::can('Users');
		$this->user = $user;
		parent::__construct();
        $this->request = $request;
	}

    public function index($value='')
    {
    	$all_users = $this->user->where('id', '!=', $this->current_user->id)->get();
    	$data = array('all_users' => $all_users);
    	return view('tenant.users.list')->withPageTitle('All Users')->with($data);
    }

    public function saveUser(Request $request)
    {
        $this->rules['email'] = 'required|email|unique:fb_users';
        $this->rules['password'] = 'required|between:5,25';
        $this->rules['confirm_password'] = 'required|same:password';
        $validator = \Validator::make($request->all(), $this->rules);

        if ($validator->fails())
            return \Response::json(array('fail' => true, 'errors' => $validator->getMessageBag()->toArray()));

        $result = $this->user->addUserDetails($request);
        $redirect_url = \URL::route('tenant.users');
        return \Response::json(array('success' => true, 'data' => $result['data'], 'template'=>$result['template'], 'redirect_url' => $redirect_url ));
    }

    
    public function blockUser()
    {
    	$guid = $this->request->route('guid');
        $user = User::where('guid', $guid)->first();

        if(!empty($user))
        {
            $user->status = 3;
            $user->save();
            $user->raw_status = $user->status;
            $data = $this->user->toFomatedData($user);
            $template = $this->user->getTemplate($user);
            return \Response::json(array('success' => true, 'data' => $data, 'template' => $template, 'message' => 'User Blocked Successfully!' ));
        }
        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }

    public function unblockUser()
    {
    	$guid = $this->request->route('guid');
        $user = User::where('guid', $guid)->first();
        if(!empty($user))
        {
            if($user->activation_key == NULL)
                $user->status = 1;
            else
                $user->status = 0;
            $user->save();

            $user->raw_status = $user->status;
            $data = $this->user->toFomatedData($user);
            $template = $this->user->getTemplate($user);
            return \Response::json(array('success' => true, 'data' => $data, 'template' => $template, 'message' => 'User Unblocked Successfully!' ));
        }
        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }

    public function deleteUser()
    {
    	$guid = $this->request->route('guid');
        $user = User::where('guid', $guid)->first();

        if(!empty($user))
        {
            //delete profile 
            $profile = Profile::where('user_id', $user->id) ->first();
            $profile->delete();
            $user->delete();
            return $this->success(['message' => 'User deleted Successfully!']);
        }
        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }

    public function authenticateUser($guid='')
    {
        if($guid == '') show_404();
        $user = $this->user->with('profile')->where('guid',$guid)->first(); 
        if(!$user) show_404();
        return $user;
    }

    public function getUpdate()
    {
    	$guid = $this->request->route('guid');
        $user = $this->user->getUserDetails($guid);
        $mode = 'edit';
        return view('tenant.users.edit', compact('user', 'mode'));
    }

    public function profile()
    {
    	$guid = $this->request->route('guid');
        $user = User::where('guid', $guid)->first();
        $profile = Profile::where('user_id', $user->id)->first();
        return view('tenant.users.profile', compact('user', 'profile'))->withPageTitle('User Details');
    }

    public function updateUser(Request $request)
    {
        $user = User::where('guid', $this->request['guid'])->first();
        $this->rules['email'] = 'required|email|unique:fb_users,email,'.$user->id; //ignore a id
        $validator = \Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return \Response::json(array('fail' => true, 'errors' => $validator->getMessageBag()->toArray()));
        $result = $this->user->updateUser($this->request);
        $redirect_url = \URL::route('tenant.users');
        return \Response::json(array('success' => true, 'data' => $result['data'], 'template'=>$result['template'], 'redirect_url' => $redirect_url ));
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['guid', 'fullname', 'email', 'status', 'created_at'];
            $json = $this->user->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }
    
}