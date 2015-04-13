<?php
namespace App\Http\Controllers\Tenant\Users;

use App\Http\Controllers\Tenant\BaseController;
use Illuminate\Support\Facades\Request as FacadeRequest;
use App\Models\Tenant\User;
use App\Models\Tenant\Setting;
use App\Models\Tenant\Profile;
use App\Models\Tenant\Vacation;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected $request;
    protected $user;
    protected $setting;
    protected $vacation;

    protected $rules = array(
        'fullname' => 'required|between:2,30',
        'email' => 'required|email',
        'phone' => 'numeric',
        'address' => 'required|between:2,50',
        'postcode' => 'required|numeric',
        'town' => 'alpha|between:2,50',
        //'photo' => 'image',
        'incoming_server' => 'min:8|required_with:outgoing_server,email_username,email_password',
        'outgoing_server' => 'min:8|required_with:incoming_server,email_username,email_password',
        'email_username' => 'min:5|required_with:incoming_server,outgoing_server,email_password',
        'email_password' => 'min:5|required_with:incoming_server,outgoing_server,email_username',
    );

    public function __construct(User $user, Request $request, Setting $setting, Vacation $vacation)
    {
        \FB::can('Users');
        $this->user = $user;
        $this->setting = $setting;
        parent::__construct();
        $this->request = $request;
        $this->vacation = $vacation;
    }

    public function index($value = '')
    {
        $all_users = $this->user->where('id', '!=', $this->current_user->id)->get();
        $data = array('all_users' => $all_users);
        return view('tenant.users.list')->with('pageTitle', 'All Users')->with($data);
    }

    public function saveUser(Request $request)
    {
        $this->rules['email'] = 'required|email|unique:fb_users';
        $this->rules['password'] = 'required|between:5,25';
        $this->rules['confirm_password'] = 'required|same:password';
        $this->rules['social_security_number'] = 'required|min:5|unique:fb_profile';
        $validator = \Validator::make($request->all(), $this->rules);

        if ($validator->fails())
            return \Response::json(array('fail' => true, 'errors' => $validator->getMessageBag()->toArray()));

        $result = $this->user->addUserDetails($request);
        $redirect_url = \URL::route('tenant.users');
        return \Response::json(array('success' => true, 'data' => $result['data'], 'template' => $result['template'], 'redirect_url' => $redirect_url));
    }


    public function blockUser()
    {
        $guid = $this->request->route('guid');
        $user = User::where('guid', $guid)->first();

        if (!empty($user)) {
            $user->status = 3;
            $user->save();
            $user->raw_status = $user->status;
            $data = $this->user->toFomatedData($user);
            $template = $this->user->getTemplate($user);
            return \Response::json(array('success' => true, 'data' => $data, 'template' => $template, 'message' => 'User Blocked Successfully!'));
        }
        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }

    public function unblockUser()
    {
        $guid = $this->request->route('guid');
        $user = User::where('guid', $guid)->first();
        if (!empty($user)) {
            if ($user->activation_key == NULL)
                $user->status = 1;
            else
                $user->status = 0;
            $user->save();

            $user->raw_status = $user->status;
            $data = $this->user->toFomatedData($user);
            $template = $this->user->getTemplate($user);
            return \Response::json(array('success' => true, 'data' => $data, 'template' => $template, 'message' => 'User Unblocked Successfully!'));
        }
        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }

    public function deleteUser()
    {
        $guid = $this->request->route('guid');
        $user = User::where('guid', $guid)->first();

        if (!empty($user)) {
            //delete profile 
            $profile = Profile::where('user_id', $user->id)->first();
            $profile->delete();
            $user->delete();
            return $this->success(['message' => 'User deleted Successfully!']);
        }
        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }

    public function authenticateUser($guid = '')
    {
        if ($guid == '') show_404();
        $user = $this->user->with('profile')->where('guid', $guid)->first();
        if (!$user) show_404();
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
        $profile = Profile::where('user_id', $user['id'])->first();
        return view('tenant.users.profile', compact('user', 'profile'))->with('pageTitle', 'User Details');
    }

    public function updateUser(Request $request)
    {
        $user = User::where('guid', $this->request['guid'])->first();
        $this->rules['email'] = 'required|email|unique:fb_users,email,' . $user->id; //ignore a id
        $this->rules['social_security_number'] = 'required|min:5|unique:fb_profile,social_security_number,' . $user->id . ',user_id';
        $validator = \Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return \Response::json(array('fail' => true, 'errors' => $validator->getMessageBag()->toArray()));
        $result = $this->user->updateUser($this->request);
        $redirect_url = \URL::route('tenant.users');
        return \Response::json(array('success' => true, 'data' => $result['data'], 'template' => $result['template'], 'redirect_url' => $redirect_url));
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

    function registerVacation()
    {
        $guid = $this->request->route('guid');
        $type = $this->request->route('type');

        $User = \DB::table('fb_users')->where('guid', $guid)->first();

        $vacationDays = \DB::table('fb_settings')->where('name', 'vacation')->first();
        $vacationDetails = @unserialize($vacationDays->value);

        $leaves = $this->vacation->getUserVacation($User->id);
        $sick_total = 0;
        $vacation_total = 0;

        if (!empty($leaves)) {
            foreach ($leaves as $key => $value) {
                $sick_total += $value->sick_days;
                $vacation_total += $value->vacation_days;
                $sick_leave_left = $vacationDetails['sick_days'] - $sick_total;
                $vacation_leave_left = $vacationDetails['vacation_days'] - $vacation_total;
            }

        } else {
            $sick_total = 0;
            $vacation_total = 0;
            $sick_leave_left = $vacationDetails['sick_days'];
            $vacation_leave_left = $vacationDetails['vacation_days'];
        }

        $allVacation = $this->vacation->getUserVacation($User->id);

        if ($type == 'vacation')
            return view('tenant.users.vacation', compact('sick_total', 'vacation_total', 'User', 'sick_leave_left', 'vacation_leave_left', 'allVacation'));
        else
            return view('tenant.users.sickLeave', compact('sick_total', 'vacation_total', 'User', 'sick_leave_left', 'vacation_leave_left', 'allVacation'));


    }

    function addVacation(Request $request)
    {

        $user_id = $this->request['user_id'];
        $type = $this->request['type'];
        $vacation = $this->request['vacation_days'];


        $date1 = date_create($this->request['from']);
        $date2 = date_create($this->request['to']);
        $diff = date_diff($date1, $date2);
        $leave = $diff->format('%d');
        //dd($leave.'toal'.$this->request['vacation_days']);
        if ($leave < $this->request['vacation_days']) {
            $result = $this->vacation->addVacation($request, $type, $leave);

            $total_leave = $this->vacation->totalVacation($this->request['user_id'], $type, $leave);
            // dd($total_leave);


            $leave_left = $vacation - $total_leave;

            return \Response::json(array('status' => true, 'vacation_days' => $leave_left, 'vacation_used' => $total_leave, 'leave_taken' => $leave, 'leave_left' => $leave_left));

        } else {
            return \Response::json(array('status' => false, 'message' => 'exceed time'));

        }
    }

    function deleteVacation()
    {
        $id = $this->request['leave_id'];

        $vacation = Vacation::where('id', $id)->first();
        $vacation->delete();

        return \Response::json(array('status' => true, 'message' => 'Leave deleted successfully'));

    }

    function getEmployeeSuggestions()
    {
        $name = \Input::get('fullname');
        //change this later
        $details = User::where('fullname', 'LIKE', '%' . $name . '%')->get();
        $newResult = array();

        if (!empty($details)) {
            foreach ($details as $d) {
                $new = array();
                $new['id'] = $d->id;
                $new['text'] = $d->fullname;
                array_push($newResult, $new);
            }
        }

        return $newResult;
    }
}