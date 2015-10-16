<?php
namespace App\Http\Controllers\System;

use App\Models\System\Client\Client;
use App\Models\System\User;
use Illuminate\Http\Request;

class ClientController extends BaseController
{
    protected $client;
    protected $request;

    protected $rules = [
        'given_name' => 'required|alpha|min:2|max:55',
        'surname' => 'required|alpha|min:2|max:55',
        'salary' => 'required|numeric',
        'occupation' => 'required|min:2|max:55'
    ];

    public function __construct(Client $client, Request $request)
    {
        parent::__construct();
        $this->client = $client;
        $this->request = $request;
    }

    function index()
    {
        //$posts = User::find(1)->posts() not eager loading - 1 user query and 20(suppose) posts query
        //$posts = User::find(1)->with('posts')->get() eager loading - 2 queries
        //$posts = User::find(1)->posts() eager loading
        //$test = $this->client->find(3)->client_addresses; gives only client addresses

        //$test = $posts = Client::find(3)->with('client_addresses', 'client_phones')->first()->toArray();
        return view('system.client.index');
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'preferred_name', 'given_name', 'surname', 'email', 'created_at'];

            $json = $this->client->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }

    function add()
    {
        $data['users'] = $this->get_users_array();
        return view('system.client.create', $data);
    }

    function get_users_array()
    {
        $users = User::select('id', 'email', 'given_name', 'surname')->get()->toArray();
        $data['users'][0] = 'Select user';
        foreach ($users as $user) {
            $data['users'][$user['id']] = $user['given_name'].' '.$user['surname'];
        }
        return $data['users'];
    }

    function create()
    {
        $this->rules['preferred_name'] = 'required|unique:ex_clients|alpha_dash';
        $this->rules['email'] = 'required|email|min:5|max:55|unique:ex_clients';

        $validator = \Validator::make($this->request->all(), $this->rules);

        if ($this->request->ajax()) {
            if ($validator->fails())
                return \Response::json(array('status' => 'fail', 'errors' => $validator->getMessageBag()->toArray()));
            $client_id = $this->client->add($this->request->all());
            return $this->success(array('clientName' => $this->request->input('given_name') . ' ' . $this->request->input('surname'), 'id' => $client_id));
        } else {
            if ($validator->fails())
                return redirect()->back()->withErrors($validator)->withInput();
            $client_id = $this->client->add($this->request->all());
            \Flash::success('Client added successfully!');
            return redirect()->route('system.client');
        }
    }

    function edit()
    {
        $client_id= $this->request->route('id');
        $data['users'] = $this->get_users_array();
        $data['client'] = Client::where('id', $client_id)->with('client_addresses.address', 'client_phones.phone')->first();
        //dd($data['client']->toArray());
        return view('system.client.edit', $data);
    }

    function update()
    {
        $client_id= $this->request->route('id');
        $this->rules['preferred_name'] = 'required|unique:ex_clients,preferred_name,'.$client_id.'|alpha_dash';
        $this->rules['email'] = 'required|email|min:5|max:55|unique:ex_clients,email,'.$client_id;

        $validator = \Validator::make($this->request->all(), $this->rules);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->client->edit($this->request->all(), $client_id);

        \Flash::success('Client updated successfully!');
        return redirect()->route('system.client');
    }

    function delete()
    {
        $client_id = $this->request->route('id');
        $this->client->remove($client_id);

        return $this->success(['message' => 'Client deleted Successfully']);
    }

    function details()
    {
        $client_id = $this->request->route('id');
        $client = Client::select('id', 'preferred_name', 'given_name', 'surname')->find($client_id);
        $client->phone = $client->currentPhone();
        $view = view('system.client.details', ['client' => $client]);
        $template = $view->render();
        return $this->success(['template' => $template]);
    }

}