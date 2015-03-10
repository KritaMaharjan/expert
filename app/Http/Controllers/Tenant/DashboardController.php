<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\User;
use Auth;

class DashboardController extends BaseController {


    function __construct()
    {
        parent::__construct();
        $this->middleware('setup.tenant');
    }


    function index()
    {
        $first_time = $this->isFirstTime();
        $data = array('first_time' => $first_time, 'page_title' => 'FastBooks');

        return view('tenant.dashboard.index')->with($data);
    }

    function isFirstTime()
    {
        if ($this->current_user->first_time == 1) {
            $user = User::find($this->current_user->id);
            $user->first_time = 0;
            $user->save();

            return true;
        }

        return false;
    }

    function profile()
    {
        $user = User::find($this->current_user->id);
        return view('tenant.dashboard.profile', compact('user'));
    }
}