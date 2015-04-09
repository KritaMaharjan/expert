<?php 
namespace App\Http\Tenant\Statistics\Controllers;
use App\Http\Controllers\Tenant\BaseController;

class StatisticsController extends BaseController {

	public function _construct()
	{
		parent::__construct();
	}


    public function index()
    {
    	return view('tenant.statistics.index');
    }
}