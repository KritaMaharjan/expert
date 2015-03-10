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
        // share current route in all views
        View::share('current_route', Route::current()->getPath());
         //$new_tenant = Tenant::where('is_new',0)->count();
         // $new_tenant_details = Tenant::where('is_new',0)->get();

      //  View::share('new_tenant',$new_tenant);
        //  View::share('new_tenant_details',$new_tenant_details);
    }

   

}