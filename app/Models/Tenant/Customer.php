<?php
namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Customer extends Model {
	 protected $table = "fb_customers";

    protected $fillable = ['user_id', 'type','name','dob','street_name','street_number','postcode','town','telephone','mobile','image','status'];

    protected $primaryKey = "id";


    function dataTablePagination(Request $request, array $select = array())
    {

        if ((is_array($select) AND count($select) < 1)) {
            $select = "*";
        }

        $take = ($request->input('length') > 0) ? $request->input('length') : 15;
        $start = ($request->input('start') > 0) ? $request->input('start') : 0;

        $search = $request->input('search');
        $search = $search['value'];
        $order = $request->input('order');
        $column_id = $order[0]['column'];
        $columns = $request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $customer = array();
        $query = $this->select($select);

        if ($orderColumn != '' AND $orderdir != '') {
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        if ($search != '') {
            $query = $query->where('name', 'LIKE', "%$search%");
        }
        $customer['total'] = $query->count();


        $query->skip($start)->take($take);

        $customer['data'] = $query->get()->toArray();

        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $customer['total'];
        $json->recordsFiltered = $customer['total'];
        $json->data = $customer['data'];

        return $json;
    }

    function toData()
    {
        $this->show_url = tenant()->url('customer/' . $this->id);
        $this->edit_url = tenant()->url('customer/' . $this->id . '/edit');
        return $this->toArray();
    }

}
