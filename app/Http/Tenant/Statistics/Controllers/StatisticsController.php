<?php 
namespace App\Http\Tenant\Statistics\Controllers;
use App\Http\Controllers\Tenant\BaseController;

use Illuminate\Http\Request;
use App\Http\Tenant\Statistics\Repositories\CustomerRepository;
use App\Http\Tenant\Statistics\Repositories\BillRepository;
use App\Http\Tenant\Statistics\Repositories\CollectionRepository;
use App\Http\Tenant\Statistics\Repositories\AccountRepository;

class StatisticsController extends BaseController {

	public function __construct(CustomerRepository $customer_repo, BillRepository $bill_repo, CollectionRepository $collection_repo, AccountRepository $account_repo, Request $request)
	{
		parent::__construct();
        $this->customer_repo = $customer_repo;
        $this->bill_repo = $bill_repo;
        $this->collection_repo = $collection_repo;
        $this->account_repo = $account_repo;
        $this->request = $request;
	}

    public function index()
    {
        $filter = $this->request->all();
        $customer_stats = $this->customer_repo->getCustomerStats($filter);
        $bill_stats = $this->bill_repo->getBillStats($filter);
        $collection_stats = $this->collection_repo->getCollectionStats($filter);
        $account_stats = $this->account_repo->getAccountStats($filter);
    	return view('tenant.statistics.index', compact('customer_stats', 'bill_stats', 'account_stats', 'collection_stats', 'filter'));
    }

    public function graph()
    {
        $filter = $this->request->all();
        switch($filter['selected']) {
            case "Customers":
                $graph_data = $this->customer_repo->getCustomerStats($filter);
                $graph_data = $graph_data['customers_chart_data'];
                $ykeys = ['value1', 'value2', 'value3'];
                $labels = ['Total Customers', 'Active Customers', 'Total Emails'];
                break;
            case "Billing":
                $graph_data = $this->bill_repo->getBillStats($filter);
                $graph_data = $graph_data['bill_chart_data'];
                $ykeys = ['value1', 'value2', 'value3'];
                $labels = ['Total Bills', 'Not sent to Collections', 'Total Offers'];
                break;
            case "Collection":
                $graph_data = $this->collection_repo->getCollectionStats($filter);
                $graph_data = $graph_data['collection_chart_data'];
                $ykeys = ['value1', 'value2', 'value3', 'value4', 'value5'];
                $labels = ['Total Cases', 'Total Bills', 'Total Purring', 'Total Inkassovarsel', 'Total Betalingsoppfordring'];
                break;
            case "Accounts":
                $graph_data = $this->account_repo->getAccountStats($filter);
                $graph_data = $graph_data['accounts_chart_data'];
                $ykeys = ['value2', 'value3', 'value5'];
                $labels = ['Total Expense', 'Paid Salary', 'Total Sales'];
                break;
        }

        $template = \View::make('tenant.statistics.graph', compact('graph_data', 'ykeys', 'labels'))->render();
        return $this->success(['template' => $template]);
    }
}