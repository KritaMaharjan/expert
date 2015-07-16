<?php

namespace App\Http\Controllers\System;

use App\Models\System\Client;
use Illuminate\Http\Request;

class ClientController extends BaseController {


    protected $client;
    protected $request;
    protected $rules = [
        'username' => 'required|unique:ex_clients|alpha_dash',
        'fname' => 'required|alpha|min:2|max:55',
        'lname' => 'required|alpha|min:2|max:55',
        'phone1' => 'required|min:10|max:15',
        'phone2' => 'min:10|max:15',
        'email' => 'required|email|min:5|max:55',
        'salary' => 'required|numeric',
        'occupation' => 'required|min:2|max:55',
        'address' => 'required|min:2',
        'introducer' => 'min:2|max:55',
    ];

    public function __construct(Client $client, Request $request)
    {
        parent::__construct();
        $this->client = $client;
        $this->request = $request;
    }

    function index()
    {
        return view('system.user.index');
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'username', 'fname', 'lname', 'email', 'created_at'];
            $json = $this->client->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }

    function add()
    {
        return view('system.user.create');
    }

    function create()
    {
        $validator = \Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->client->add($this->request->all());

        \Flash::success('Client added successfully!');
        return tenant()->route('system.user');
    }
}