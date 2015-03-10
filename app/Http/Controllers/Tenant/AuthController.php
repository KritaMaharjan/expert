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

    function __construct(Guard $auth)
    {
        parent::__construct();
        $this->auth = $auth;
    }


    public function getLogin()
    {
        return view('tenant.auth.login');
    }


    public function postLogin(Request $request, TenantUser $TenantUser)
    {
        $validator = Validator::make($request->all(), array('email' => 'required', 'password' => 'required'));
        if ($validator->fails())
            return redirect()->route('tenant.login')->withErrors($validator)->withInput();

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            $this->rememberTenant();

            return $TenantUser->redirectIfValid($this->auth->user());
        }

        return redirect()->route('tenant.login')->with('message', 'These credentials do not match our records.')->withInput($request->only('email', 'remember'));
    }


    private function rememberTenant()
    {
        session()->put('APPURL', $this->auth->user()->domain);
        setcookie("APPURL", $this->auth->user()->domain, time() + (86400 * 365 * 5), '/');
    }


    public function logout()
    {
        $this->auth->logout();

        return redirect()->route('tenant.login');
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

        return redirect()->route('tenant.login')->with('message', 'Password has been changed.');


    }

    /**
     * @param string $activation_key
     * @return \Illuminate\View\View
     */
    public function confirm($activation_key = '')
    {
        $subuser = $this->checkActivation($activation_key);

        if (!$subuser)
            return view('errors.404');

        $this->activateSubUser($subuser);

        return \FB::tenant_url($subuser->domain);
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

        $this->saveRegistrationSession($subuser);
    }

    /**
     * @param $subuser
     */
    private function saveRegistrationSession($subuser)
    {
        $registration_details = array(
            'company'    => $subuser->company,
            'guid'       => $subuser->guid,
            'domain'     => $subuser->domain,
            'email'      => $subuser->email,
            'first_time' => true
        );

        Session::put('register_tenant', $registration_details);
    }

}