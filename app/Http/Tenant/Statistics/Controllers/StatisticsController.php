<?php 
namespace App\Http\Tenant\Statistics\Controllers;
use App\Http\Controllers\Tenant\BaseController;

use App\Http\Tenant\Statistics\Repositories\CustomerRepository;
use App\Http\Tenant\Statistics\Repositories\BillRepository;
use App\Http\Tenant\Statistics\Repositories\CollectionRepository;
use App\Http\Tenant\Statistics\Repositories\AccountRepository;

class StatisticsController extends BaseController {

	public function __construct(CustomerRepository $customer_repo, BillRepository $bill_repo, CollectionRepository $collection_repo, AccountRepository $account_repo)
	{
		parent::__construct();
        $this->customer_repo = $customer_repo;
        $this->bill_repo = $bill_repo;
        $this->collection_repo = $collection_repo;
        $this->account_repo = $account_repo;
	}

    public function index()
    {
        dd($this->account_repo->getSalesCost());
        $customer_stats = $this->customer_repo->getCustomerStats();
        $bill_stats = $this->bill_repo->getBillStats();
        $collection_stats = $this->collection_repo->getCollectionStats();
        $account_stats = $this->account_repo->getAccountStats();
    	return view('tenant.statistics.index', compact('customer_stats', 'bill_stats', 'account_stats', 'collection_stats'));
    }
}