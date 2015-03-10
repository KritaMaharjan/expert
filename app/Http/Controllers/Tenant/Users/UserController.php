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
                'phone' => 'between:10,15',
                'address' => 'required|between:2,50',
                'postcode' => 'required|size:5',
                'town' => 'between:2,50',
                'photo' => 'image',
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

    public function saveUserDetails($details)
    {
        if(isset($details['permissions'])){
            $per = serialize($details['permissions']);
        } else {
            $per = '';
        }
        $user = User::create([
                    'fullname' => $details['fullname'],
                    'password' => \Hash::make($details['password']),
                    'role' => 2, //sub-user
                    'first_time' => 1,
                    'email' => $details['email'],
                    'status' => 0, //pending
                    'activation_key' => \FB::uniqueKey(15, 'fb_users', 'activation_key'),
                    'permissions' => $per
            ]);

        $user_id = $user->id;

        $fileName = NULL;
        if (FacadeRequest::hasFile('photo'))
        {
            $file = FacadeRequest::file('photo');
            $fileName = \FB::uploadFile($file);
        }

        $email_setting_details = $details->only('incoming_server', 'outgoing_server', 'email_username', 'email_password');
        $personal_email_setting = json_encode($email_setting_details);

        $profile = Profile::create([
                    'user_id' => $user_id,
                    'phone' => $details['phone'],
                    'address' => $details['address'],
                    'postcode' => $details['postcode'],
                    'town' => $details['town'],
                    'comment' => $details['comment'],
                    'tax_card' => $details['tax_card'],
                    'photo' => $fileName,
                    'social_security_number' => $details['social_security_number'],
                    'personal_email_setting' => $personal_email_setting
            ]);

        $this->sendConfirmationMail($user->activation_key, $details['name'], $details['email']);
    }

    /**
     * Send activation code in user's email
     * @param string $activation_key
     * @param string $username
     * @param string $email
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function sendConfirmationMail($activation_key = '', $username = '', $email = '')
    {
        $link = \URL::route('subuser.register.confirm', $activation_key); //change this
        \FB::sendEmail($email, $username, 'confirmation_email', ['{{NAME}}' => $username, '{{ACTIVATION_URL}}' => $link." "]);
        $message = 'User created successfully.';
        \Flash::success($message);
    }

    public function blockUser($guid='')
    {
        $user = User::where('guid', $guid)->first();

        if(!empty($user))
        {
            $user->status = 3;
            $user->save();
            $data = $this->user->toFomatedData($user);
            return \Response::json(array('status' => true, 'data' => $data, 'message' => 'User Blocked Successfully!' ));
        }
        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }

    public function unblockUser($guid='')
    {
        $user = User::where('guid', $guid)->first();
        if(!empty($user))
        {
            if($user->activation_key == NULL)
                $user->status = 1;
            else
                $user->status = 0;
            $user->save();
            $data = $this->user->toFomatedData($user);
            return \Response::json(array('status' => true, 'data' => $data, 'message' => 'User Unblocked Successfully!' ));
        }
        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }

    public function deleteUser($guid='')
    {
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

    public function getUpdate($guid='')
    {
        $user = $this->user->getUserDetails($guid);
        $mode = 'edit';
        return view('tenant.users.edit', compact('user', 'mode'));
    }

    public function profile($guid='')
    {
        $user = User::where('guid', $guid)->first();
        $profile = Profile::where('user_id', $user->id)->first();
        return view('tenant.users.profile', compact('user', 'profile'))->withPageTitle('User Details');
    }

    public function updateUser(Request $request)
    {
        $user = User::where('guid', $request['guid'])->first();
        $this->rules['email'] = 'required|email|unique:fb_users,email,'.$user->id; //ignore a id
        $validator = \Validator::make($request->all(), $this->rules);

        if ($validator->fails())
            return \Response::json(array('fail' => true, 'errors' => $validator->getMessageBag()->toArray()));
        $result = $this->user->updateUser($request);
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