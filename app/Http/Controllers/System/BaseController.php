<?php
/**
 * Created by PhpStorm.
 * User: manishg.singh
 * Date: 2/16/2015
 * Time: 10:25 AM
 */

namespace App\Http\Controllers\System;


use App\Http\Controllers\Controller;
use App\Models\System\Tenant;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;


class BaseController extends Controller {


    function __construct()
    {
        if($this->isSubDomain())
        {
            show_404();
        }

        // share current route in all views
        View::share('current_route', Route::current()->getPath());
    }



    function isSubDomain()
    {

    }

   

}