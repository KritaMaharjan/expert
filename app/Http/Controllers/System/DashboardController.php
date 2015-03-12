<?php namespace App\Http\Controllers\System;

class DashboardController extends BaseController {


    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        return view('system.dashboard.index');
    }


}
