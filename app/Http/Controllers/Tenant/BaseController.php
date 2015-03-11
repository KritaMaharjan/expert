<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Models\Tenant\Setting;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller {


    protected $current_user;

    function __construct()
    {
        $this->current_user();
        // share current route in all views
        View::share('current_user', $this->current_user);
        View::share('current_route', Route::current()->getPath());
        View::share('current_path', Request::path());
        View::share('company_logo', $this->getCompanyLogo());
        View::share('domain', session()->get('domain'));
    }


    function current_user()
    {
        if (Auth::check()) {
            return $this->current_user = Auth::user();
        } else {
            return $this->current_user = null;
        }
    }


    function getCompanyLogo()
    {
        $company_details = Setting::where('name', 'fix')->first();

        if (isset($company_details->value) AND isset($company_details['logo']))
            return asset('assets/uploads/' . $company_details['logo']);
        else
            return asset('assets/images/logo.png');
    }

    function success(array $data = array())
    {
        $response = ['status' => 1, 'data' => $data];

        return \Response::json($response);
    }


    function fail(array $data = array())
    {
        $response = ['status' => 0, 'data' => $data];

        return \Response::json($response);
    }


}
