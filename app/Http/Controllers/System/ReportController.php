<?php
namespace App\Http\Controllers\System;

use App\Models\System\Lead\Lead;
use Illuminate\Http\Request;

class ReportController extends BaseController
{
    protected $lead;
    protected $request;

    protected $rules = [
        'given_name' => 'required|alpha|min:2|max:55',
        'surname' => 'required|alpha|min:2|max:55'
    ];

    public function __construct(Lead $lead, Request $request)
    {
        parent::__construct();
        $this->lead = $lead;
        $this->request = $request;
    }

    function index()
    {
        return view('system.report.index');
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'username', 'given_name', 'surname', 'email', 'created_at', 'role'];

            $json = $this->user->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }

}