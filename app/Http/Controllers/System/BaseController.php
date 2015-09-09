<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\Tenant;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;


class BaseController extends Controller {


    function __construct()
    {
        // share current route in all views
        View::share('current_url', Route::current()->getPath());
        // share current logged in user details all views
        View::share('current_user', $this->current_user());
    }

    public function current_user()
    {
        $current_user = \Auth::user();
        return $current_user;
    }

    /**
     * return success json data to view
     * @param array $data
     * @return mixed
     */
    function success(array $data = array())
    {
        $response = ['status' => 1, 'data' => $data];

        return Response::json($response);
    }


    /**
     * return failed json data to view
     * @param array $data
     * @return mixed
     */
    function fail(array $data = array())
    {
        $response = ['status' => 0, 'data' => $data];

        return Response::json($response);
    }

}