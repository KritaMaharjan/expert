<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use FB;
use DB;
use Hash;


class RemindersController extends BaseController {


    public function forgetPassword()
    {
        return view('tenant.auth.reset');
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @param Request $request
     * @param Tenant $tenant
     * @return Response
     */
    public function postForgotPassword(Request $request, User $tenant)
    {

        $user = $tenant->where('email', $request->input('email'))->first();
        if (!empty($user)) {
            $this->sendResetEmail($user);

            return tenant()->route('tenant.login')->with('message_success', 'Reset Email sent to your email successfully');
        }

        return tenant()->route('tenant.forgetPassword')->with('message', 'These credentials do not match our records.');
    }

    function sendResetEmail($user)
    {
        $confirmation_code = str_random(30);
        DB::table('fb_password_resets')->insert(array('email' => $user->email, 'token' => $confirmation_code, 'created_at' => date('Y-m-d h:i:s')));
        $link = tenant()->url('reset-password') . '/' . $confirmation_code . " ";
        $no_link = tenant()->url('/');

        \FB::sendEmail($user->email, $user->fullname, 'forgot_password', ['{{RESET_URL}}' => $link, '{{DONT_RESET_URL}}' => $no_link, '{{ USERNAME }}' => $user->fullname, '{{ NAME }}' => $user->fullname]);

    }


    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     * @return Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) \App::abort(404);

        return view('system.auth.passwordreset')->with('token', $token);
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return Response
     */
    public function postReset()
    {
        $rules = array('email' => 'required', 'new_password' => 'required|min:6', 'new_password_confirmation' => 'required|same:new_password|min:6');
        $user_reset = DB::table('fb_password_resets')->where('token', Input::only('confirmed_code'))->first();

        if (!empty($user_reset)) {
            $user = DB::table('fb_password_resets')->where('email', Input::only('email'))->first();
            $validator = \Validator::make(\Input::all(), $rules);

            //Is the input valid? new_password confirmed and meets requirements
            if ($validator->fails()) {
                return \Redirect::back()->withErrors($validator)->withInput();
            }

            $newpassword = Hash::make(Input::get('new_password'));

            \DB::table('fb_users')
                ->where('email', Input::only('email'))
                ->update(['password' => $newpassword]);

            \DB::table('fb_password_resets')->where('email', '=', Input::only('email'))->delete();

            return tenant()->route('tenant.login')->with('message_success', 'Password Reset successfully.');

        } else {
            return tenant()->route('tenant.login')->with('message', 'Invalid url');
        }


    }
}

?>