<?php

namespace App\Http\Controllers\System;

use App\Models\System\User;
use App\Models\System\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use FB;
use DB;
use Hash;


class RemindersController extends BaseController {


    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Display the password reminder view.
     *
     * @return Response
     */
    public function getForgotPassword()
    {
        return view('system.auth.reset');
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return Response
     */
    public function postForgotPassword()
    {
        $user = User::where('email', '=', Input::only('email'))->first();
        if (!empty($user)) {
            $this->sendResetEmail($user);

            return redirect('system/login')->with('message_success', 'Reset Email sent to your email successfully');
        } else
            return redirect('system/forgot-password')->with('message', 'These credentials do not match our records.');

    }

    function sendResetEmail($user)
    {
        $confirmation_code = str_random(30);
        DB::table('password_resets')->insert(array('email' => $user->email, 'token' => $confirmation_code, 'created_at' => date('Y-m-d h:i:s')));

        $link = \URL::to('system/reset-password') . '/' . $confirmation_code . "  ";

        $mail = \EX::sendEmail($user->email, $user->fullname, 'forgot_password', ['{{RESET_URL}}' => $link, '{{ USERNAME }}' => $user->fullname, '{{ NAME }}' => $user->fullname]);
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
        $user_reset = DB::table('password_resets')->where('token', Input::only('confirmed_code'))->first();

        if (!empty($user_reset)) {
            $user = DB::table('password_resets')->where('email', Input::only('email'))->first();
            $validator = \Validator::make(\Input::all(), $rules);

            //Is the input valid? new_password confirmed and meets requirements
            if ($validator->fails())
                return \Redirect::back()->withErrors($validator)->withInput();


            $newpassword = Hash::make(Input::get('new_password'));
            \DB::table('ex_users')->where('email', Input::only('email'))->update(['password' => $newpassword]);
            DB::table('password_resets')->where('email', '=', Input::only('email'))->delete();

            return redirect('system/login')->with('message_success', 'Password Reset successfully.');

        } else
            return redirect('system/login')->with('message', 'Invalid link.');
    }
}

?>