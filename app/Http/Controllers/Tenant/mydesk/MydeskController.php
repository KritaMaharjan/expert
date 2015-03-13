<?php namespace App\Http\Controllers\mydesk\mydesk;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MydeskController extends BaseController {


    protected $request;

    public function __construct(Request $request)
    {
        
        
        parent::__construct();
       
        $this->request = $request;
    }


     public  function index(){

     	return view('');
     }


}
?>