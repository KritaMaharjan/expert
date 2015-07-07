<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class BaseController extends Controller {

	function __construct()
    {
        // share current route in all views
        View::share('current_route', Route::current()->getPath());
    }

} 