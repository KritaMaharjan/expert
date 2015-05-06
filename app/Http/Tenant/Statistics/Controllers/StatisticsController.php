<?php 
namespace App\Http\Tenant\Statistics\Controllers;
use App\Http\Controllers\Tenant\BaseController;

use App\Http\Tenant\Statistics\Repositories\CustomerRepository;
use App\Http\Tenant\Statistics\Repositories\BillRepository;

class StatisticsController extends BaseController {

	public function __construct(CustomerRepository $customer_repo, BillRepository $bill_repo)
	{
		parent::__construct();
        $this->customer_repo = $customer_repo;
        $this->bill_repo = $bill_repo;
	}

    public function index()
    {
        $customer_stats = $this->customer_repo->getCustomerStats();
        $bill_stats = $this->bill_repo->getBillStats();
    	return view('tenant.statistics.index', compact('customer_stats', 'bill_stats'));
    }
}