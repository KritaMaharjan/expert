<?php

namespace App\Http\Controllers\System;

use App\Models\System\User;
use App\Models\System\Setting;
use Illuminate\Http\Request;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use FB;
use URL;
use Session;


class AuthController extends BaseController {

    protected $auth;

    function __construct(Guard $auth)
    {
        parent::__construct();
        $this->auth = $auth;
    }

    public function getLogin()
    {
        return view('system.auth.login');
    }


    public function postLogin(Request $request, User $systemUser)
    {
        $validator = Validator::make($request->all(), array('email' => 'required', 'password' => 'required'));
        if ($validator->fails())
            return redirect()->to('system/login')->withErrors($validator)->withInput();

        $credentials = $request->only('email', 'password');
        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            return $systemUser->redirectIfValid($this->auth->user());
        }

        return redirect('system/login')->with('message', 'These credentials do not match our records.')->withInput($request->only('email', 'remember'));
    }


    public function logout()
    {
        $this->auth->logout();

        return redirect('system/login');
    }


    function changePassword()
    {
        return view('system.auth.changePassword');

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

        return \Redirect::to('system')->withMessage('Password has been changed.');


    }


}
