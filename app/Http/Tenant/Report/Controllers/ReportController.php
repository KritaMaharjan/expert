<?php 
namespace App\Http\Tenant\Report\Controllers;
use App\Http\Controllers\Tenant\BaseController;

class ReportController extends BaseController {

	public function _construct()
	{
		parent::__construct();
	}


    public function index()
    {
    	return view('tenant.report.index');
    }
}