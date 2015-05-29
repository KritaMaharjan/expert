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
        if($tenant->basic->activation_key =='')
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

    function deleteTenant(){
        $domain = $this->request->route('domain'); 
        $tenant = new stdclass;
          $tenant->basic  = Tenant::where('domain',$domain)->first();

       
        if($tenant->basic->activation_key =='')
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

            $table_customers = $dbname . '.' . env('ROOT_TABLE_PREFIX') . 'customers';
            $tenant->customers = DB::table($table_customers . ' as customers')
                ->select('customers.*')
                ->where('user_id', 1)// Admin profile / later weill join table get profile by guid
                ->count();

                 $table_bill = $dbname . '.' . env('ROOT_TABLE_PREFIX') . 'bill';
            $tenant->bill = DB::table($table_bill . ' as bill')
                ->select('bill.*')
               // ->where('user_id',1)// Admin profile / later weill join table get profile by guid
                ->count();

                   $table_inventory = $dbname . '.' . env('ROOT_TABLE_PREFIX') . 'inventory';
            $tenant->inventory = DB::table($table_inventory . ' as inventory')
                ->select('inventory.*')
               // ->where('user_id',1)// Admin profile / later weill join table get profile by guid
                ->count();


                   $table_users = $dbname . '.' . env('ROOT_TABLE_PREFIX') . 'users';
            $tenant->users = DB::table($table_users . ' as users')
                ->select('users.*')
               // ->where('user_id',1)// Admin profile / later weill join table get profile by guid
                ->count();
        }

        return view('system.user.details', compact('tenant'));
    }

    function confirmDelete(){
        $domain = $this->request->route('domain'); 
        $tenant = new stdclass;
          $tenant->basic  = Tenant::where('domain',$domain)->first();

       
        if($tenant->basic->activation_key =='')
        {
            $dbname = env('ROOT_DB_PREFIX') . $tenant->basic->domain;
           
                 $table_settings = $dbname . '.' . env('ROOT_TABLE_PREFIX') . 'settings';

                $company = DB::table($table_settings . ' as setting')
                    ->select('setting.value','setting.name')
                    ->where('setting.name', 'folder')->first();

                $company_folder = $company->value;
                \DB::statement('drop database '.$dbname.';');
                $folder_path = public_path().'\files'.'\\' .$company_folder;
                //dd($folder_path);

                $this->rrmdir($folder_path);

            $client = Tenant::where('id', $tenant->basic->id)->first();
             $client->delete();

            return redirect('system/client');
               
        }else{
             $client = Tenant::where('id', $tenant->basic->id)->first();
             $client->delete();
             return redirect('system/client')->with('message', 'Client deleted successfully');
        }

    }


function rrmdir($dir) {
   // dd($dir);
  if (is_dir($dir)) {

    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir") 
           $this->rrmdir($dir."/".$object); 
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }else{
    return true;
  }
  
 }



}