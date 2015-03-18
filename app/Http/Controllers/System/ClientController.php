<?php
/**
 * User: manishg.singh
 * Date: 2/19/2015
 * Time: 2:50 PM
 */

namespace App\Http\Controllers\System;

use anlutro\cURL\Laravel\cURL;
use App\Models\System\Tenant;
use App\Models\System\User;
use Response;
use Auth;
use Input;
use DB;
use stdclass;
use Schema;
use Illuminate\Http\Request;


class ClientController extends BaseController {


    protected $client;
    protected $request;


    public function __construct(Tenant $client, Request $request)
    {
        parent::__construct();
        $this->client = $client;
        $this->request = $request;

    }

    function index()
    {


        return view('system.user.index', compact('tenants'));
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'domain', 'email', 'status', 'guid'];

            $json = $this->client->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }


    function show($id)
    {
        $tenant = new stdclass;
        $tenant->basic = Tenant::find($id);
        if$tenant->basic->activation_key =='')
        {
            $dbname = env('ROOT_DB_PREFIX') . $tenant->basic->domain;
            $table_profile = $dbname . '.' . env('ROOT_TABLE_PREFIX') . 'profile';
            $tenant->profile = DB::table($table_profile . ' as profile')
                ->select('profile.*')
                ->where('user_id', 1)// Admin profile / later weill join table get profile by guid
                ->first();
            $table_settings = $dbname . '.' . env('ROOT_TABLE_PREFIX') . 'settings';
            $company = DB::table($table_settings . ' as setting')
                ->select('setting.value','setting.name')
                ->where('setting.name', 'company')
                ->orWhere('setting.name', 'business')
                ->get();


            foreach ($company as $key => $com) {
                $k = $com->name;
                $tenant->$k = @unserialize($com->value);
            }

        }

        return view('system.user.show', compact('tenant'));
    }

    function profile()
    {
        $user = Auth::user();

        return view('system.user.profile', compact('user'));

    }

    function block()
    {


        if (\Input::get('code') == '') {
            return \Response::json(['status' => 'false', 'message' => 'Error Message']);
        }

        $tenant = Tenant::where('guid', \Input::get('code'))->first();

        if (is_null($tenant)) {

            return \Response::json(['status' => 'false', 'message' => 'Invaid Tenant ID']);

        } else {

            if ($tenant->status == 1) {
                Tenant::where('guid', \Input::get('code'))->update(array('status' => 0));

                return \Response::json(['status' => 'true', 'message' => 'Account blocked success', 'block' => 'Unblock']);

            } else {
                Tenant::where('guid', \Input::get('code'))->update(array('status' => 1));

                return \Response::json(['status' => 'true', 'message' => 'Account unblocked success', 'block' => 'Block']);

            }

        }

    }


}