<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Requests;
use App\Models\Tenant\Tenant;
use App\Models\Tenant\User as TenantUser;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Tenant\User;
use Session;
use Auth;


class AuthController extends BaseController {

    protected $auth;
    protected $request;

    function __construct(Guard $auth, Request $request)
    {
        parent::__construct();
        $this->auth = $auth;
        $this->request = $request;
    }


    public function getLogin()
    {
        return view('tenant.auth.login');
    }


    public function postLogin(Request $request, TenantUser $TenantUser)
    {
        $validator = Validator::make($request->all(), array('email' => 'required', 'password' => 'required'));
        if ($validator->fails())
            return tenant()->route('tenant.login')->withErrors($validator)->withInput();

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            $this->rememberTenant();
            return $TenantUser->redirectIfValid($this->auth->user());
        }

        return tenant()->route('tenant.login')->with('message', 'These credentials does not match our records.')->withInput($request->only('email', 'remember'));
    }


    private function rememberTenant()
    {
        setcookie("APPURL", session('domain'), time() + (86400 * 365 * 5), '/');
    }


    public function logout()
    {
        $this->auth->logout();

        return tenant()->route('tenant.login');
    }

    function blockAccount()
    {
        if (\Input::get('code') == '') {
            return \Response::json(['status' => 'false', 'message' => 'Error Message']);
        }

        $tenant = Tenant::where('guid', \Input::get('code'))->first();

        if (is_null($tenant)) {

            return \Response::json(['status' => 'false', 'message' => 'Invaid Tenant ID']);

        } else {

            if ($tenant->status == 1) {
                Tenant::where('guid', \Input::get('code'))->update(array('status' => 0));

                return \Response::json(['status' => 'true', 'message' => 'Account blocked success', 'block' => 'Unblock']);

            } else {
                Tenant::where('guid', \Input::get('code'))->update(array('status' => 1));

                return \Response::json(['status' => 'true', 'message' => 'Account unblocked success', 'block' => 'Block']);

            }

        }

    }


    function changePassword()
    {
        return view('tenant.auth.changePassword');

    }

    public function postUserPasswordChange()
    {

        $rules = array(
            'password'                  => 'required',
            'new_password'              => 'required|min:6',
            'new_password_confirmation' => 'required|same:new_password|min:6'
        );

        $user = Auth::user();
        $validator = Validator::make(\Input::all(), $rules);

        //Is the input valid? new_password confirmed and meets requirements
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        //Is the old password correct?
        if (!Hash::check(\Input::get('password'), $user->password)) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        //Set new password to user
        $user->password = Hash::make(\Input::get('new_password'));

        $user->save();

        return tenant()->route('tenant.login')->with('message', 'Password has been changed.');


    }

    /**
     * @param string $activation_key
     * @return \Illuminate\View\View
     */
    public function confirm($confirmationCode = '')
    {
        $confirmationCode = $this->request->route('confirmationCode');
        $subuser = $this->checkActivation($confirmationCode);

        if (!$subuser)
            return view('errors.404');
        $this->activateSubUser($subuser);
        Session::put('message_success', 'Your account has been activated!');
        return tenant()->redirect();
    }

    /**
     * @param string $activation_key
     * @return bool
     */
    private function checkActivation($activation_key = '')
    {
        if (!$activation_key || $activation_key == '')
            return false;

        $subuser = User::whereActivationKey($activation_key)->first();

        if (!$subuser)
            return false;

        return $subuser;
    }

    /**
     * @param string $subuser
     */
    private function activateSubUser($subuser = '')
    {
        $subuser->status = 1;
        $subuser->activation_key = null;
        $subuser->save();
    }
}