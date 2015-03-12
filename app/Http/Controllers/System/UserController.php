<?php
/**
 * User: manishg.singh
 * Date: 2/19/2015
 * Time: 2:50 PM
 */

namespace App\Http\Controllers\System;

use App\Models\System\User;
use Response;
use Auth;


class UserController extends BaseController {


    public function __construct()
    {
        parent::__construct();
    }

    function index()
    {
    }


} 