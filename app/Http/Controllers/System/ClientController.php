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


  public function __construct(Tenant $client,Request $request){
     parent::__construct();
     $this->client = $client;
     $this->request = $request;

  }

    function index()
    {
      
      
      return view('system.user.index',compact('tenants'));
    }

  public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'domain', 'email','status','guid'];

            $json = $this->client->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }


    function show($id)
    {
    	$tenant_basic = Tenant::find($id);

      $prefix = 'fbooks_';
      $dbname =  $prefix.$tenant_basic->domain;//$prefix.'manish_co';
      $table  = $dbname.'.fb_settings';
      $if_db_exists =  true;
      $tenant = new stdclass;
      $tenant->basic=$tenant_basic;
      if($if_db_exists)
      {
         $clients = DB::table($table.' as profile')
                  ->select('profile.*')
                  ->get();


        $basics = DB::table($dbname.'.fb_users as basic_info')
                  ->select('created_at')
                  ->where('email',$tenant_basic->email)
                  ->first();

          
       $tenant->created_date = $basics->created_at;
        if(!empty($clients)) {
          foreach($clients as $key=>$client){
            $new_key = $client->name;
            $tenant->$new_key=unserialize($client->value);
          
         }
        }
      }
     
    
      
        return view('system.user.show',compact('tenant'));
    }

    function profile(){
    	$user= Auth::user();
      return view('system.user.profile',compact('user'));

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