<?php
namespace App\Models\System;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'ex_clients';
    protected $fillable = ['username', 'fname', 'lname', 'phone1', 'phone2', 'email', 'salary', 'type', 'occupation', 'address', 'introducer'];

    function add(array $request)
    {
        $client = Client::create([
            'username' => $request['username'],
            'fname' => $request['fname'],
            'lname' => $request['lname'],
            'phone1' => $request['phone1'],
            'phone2' => $request['phone2'],
            'email' => $request['email'],
            'salary' => $request['salary'],
            'occupation' => $request['occupation'],
            'type' => $request['type'],
            'address' => $request['address'],
            'introducer' => $request['introducer']
        ]);

        if ($client) return true;
        else return false;
    }

    /* *
     *  Display data for ajax pagination
     *  Output stdClass
     * */
    function dataTablePagination(Request $request, array $select = array())
    {
        if ((is_array($select) AND count($select) < 1)) {
            $select = "*";
        }
        $take = ($request->input('length') > 0) ? $request->input('length') : 10;
        $start = ($request->input('start') > 0) ? $request->input('start') : 0;

        $search = $request->input('search');
        $search = $search['value'];
        $order = $request->input('order');
        $column_id = $order[0]['column'];
        $columns = $request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $client = array();
        $query = $this->select($select);

        if ($orderColumn != '' AND $orderdir != '') {
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        if ($search != '') {
            $query = $query->where('domain', 'LIKE', "%$search%")->orwhere('email', 'LIKE', "%$search%");
        }
        $client['total'] = $query->count();

        $query->skip($start)->take($take);

        $data = $query->get();

        foreach ($data as $key => &$value) {
            $value->fullname = $value->fname . " " . $value->lname;
        }
        $client['data'] = $data->toArray();
        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $client['total'];
        $json->recordsFiltered = $client['total'];
        $json->data = $client['data'];

        return $json;
    }

    function toData()
    {
        $this->show_url = '';// tenant()->url('client/' . $this->id);
        $this->edit_url = '';//tenant()->url('client/' . $this->id . '/edit');
        return $this->toArray();
    }
} 