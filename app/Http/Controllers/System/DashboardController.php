<?php namespace App\Http\Controllers\System;

use App\Models\System\Application\Application;
use Illuminate\Http\Request;
use App\Models\System\Lead\Lead;

class DashboardController extends BaseController {

    protected $request;
    protected $lead;

    public function __construct(Lead $lead, Application $application, Request $request)
    {
        parent::__construct();
        $this->request = $request;
        $this->lead = $lead;
        $this->application = $application;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $role = $this->current_user()->role;
        switch ($role) {
            case 2: //admin
                return view('system.dashboard.admin');
            case 3: //sales
                return view('system.dashboard.sales');
                break;
            case 4: //marketing
                return view('system.dashboard.index');
                break;
            default:
                return view('system.dashboard.sales');
        }
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $role = $this->current_user()->role;
            switch ($role) {
                case 2: //admin
                    $json = $this->adminData();
                    break;
                case 3: //sales
                    $json = $this->salesData();
                    break;
                case 4:
                    $json = $this->marketingData();
                    break;
                default:
                    $json = $this->salesData();
            }

            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }

    public function salesData()
    {
        $select = ['id', 'status', 'ex_clients_id', 'created_at'];
        $json = $this->lead->dataSalesTablePagination($this->request, $select, $this->current_user()->id);
        return $json;
    }

    public function marketingData()
    {
        $select = ['id', 'status', 'ex_clients_id', 'created_at'];
        $json = $this->lead->dataTablePagination($this->request, $select, true);
        return $json;
    }

    public function adminData()
    {
        $select = ['id', 'status', 'ex_clients_id', 'created_at'];
        $json = $this->application->pendingTablePagination($this->request, $select, $this->current_user()->id);
        return $json;
    }

}
