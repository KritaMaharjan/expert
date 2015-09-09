<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class BaseController extends Controller {

    function __construct()
    {
        // share current route in all views
        View::share('current_url', Route::current()->getPath());
    }

}