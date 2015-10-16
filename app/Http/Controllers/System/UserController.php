<?php
namespace App\Http\Controllers\System;

use App\Models\System\User\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected $user;
    protected $request;

    protected $rules = [
        'given_name' => 'required|alpha|min:2|max:55',
        'surname' => 'required|alpha|min:2|max:55'
    ];

    public function __construct(User $user, Request $request)
    {
        parent::__construct();
        $this->user = $user;
        $this->request = $request;
    }

    function index()
    {
        return view('system.user.index');
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

    function add()
    {
        $users = User::select('id', 'email')->get()->toArray();
        $data['users'][0] = 'Select user';
        foreach ($users as $user) {
            $data['users'][$user['id']] = $user['email'];
        }
        return view('system.user.create', $data);
    }

    function profile()
    {
        $data['user'] = User::where('id', $this->current_user()->id)->with('user_addresses.address', 'user_phones.phone')->first();
        //dd($data['user']->toArray());
        return view('system.user.profile', $data);
    }

    function create()
    {
        $this->rules['username'] = 'required|unique:ex_users|alpha_dash';
        $this->rules['email'] = 'required|email|min:5|max:55|unique:ex_users';

        $validator = \Validator::make($this->request->all(), $this->rules);

        if ($this->request->ajax()) {
            if ($validator->fails())
                return \Response::json(array('status' => 'fail', 'errors' => $validator->getMessageBag()->toArray()));
            $user_id = $this->user->add($this->request->all());
            return $this->success(array('userName' => $this->request->input('given_name') . ' ' . $this->request->input('surname'), 'id' => $user_id));
        } else {
            if ($validator->fails())
                return redirect()->back()->withErrors($validator)->withInput();
            $user_id = $this->user->add($this->request->all());
            \Flash::success('User added successfully!');
            return redirect()->route('system.user');
        }
    }

    function edit()
    {
        $user_id= $this->request->route('id');
        $data['user'] = User::where('id', $user_id)->with('user_addresses.address', 'user_phones.phone')->first();
        //dd($data['user']->toArray());
        return view('system.user.edit', $data);
    }

    function update()
    {
        $user_id= $this->request->route('id');
        $this->rules['username'] = 'required|unique:ex_users,username,'.$user_id.'|alpha_dash';
        $this->rules['email'] = 'required|email|min:5|max:55|unique:ex_users,email,'.$user_id;

        $validator = \Validator::make($this->request->all(), $this->rules);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->user->edit($this->request->all(), $user_id);

        \Flash::success('User updated successfully!');
        if($user_id != $this->current_user()->id)
            return redirect()->route('system.user');
        else
            return redirect()->route('system.user.profile');
    }

    function delete()
    {
        $user_id = $this->request->route('id');
        $this->user->remove($user_id);

        return $this->success(['message' => 'User deleted Successfully']);
    }

}