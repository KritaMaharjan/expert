<?php


namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class Tenant extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tenants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'company', 'guid', 'email', 'password', 'status', 'activation_key', 'domain'];


    protected $connection = 'master';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['activation_key'];





    function actionWithStatus()
    {
        if ($this->status == 0) {
            die('account activation pending');
        } elseif ($this->status == 2) {
            die('Account suspended');
        }

    }


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
            $query = $query->where('domain', 'LIKE', "%$search%")->orwhere('email','LIKE',"%$search%");
        }
        $client['total'] = $query->count();


        $query->skip($start)->take($take);

        $client['data'] = $query->get()->toArray();

        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $client['total'];
        $json->recordsFiltered = $client['total'];
        $json->data = $client['data'];

        return $json;
    }

    function toData()
    {
        $this->show_url ='';// tenant()->url('client/' . $this->id);
        $this->edit_url = '';//tenant()->url('client/' . $this->id . '/edit');
        return $this->toArray();
    }


    /**
     * Model events observe
     *
     * @return void
     **/
    public static function boot()
    {
        parent::boot();
        static::creating(function($tenant) {
            if($tenant->guid == '')
                $tenant->guid = \FB::uniqueKey(10, 'tenants','guid');
        });
    }
} 