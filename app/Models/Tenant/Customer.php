<?php
namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Customer extends Model {
	 protected $table = "fb_customers";

    protected $fillable = ['user_id', 'type','name','email','dob','street_name','street_number','postcode','town','telephone','mobile','image','status'];

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

         $data = $query->get();

        foreach ($data as $key => &$value) {
            $value->name = "<a href=".\URL::route('tenant.customer.CustomerCard', $value->id).">".$value->name."</a>";
           $value->email = $value->email;
            $value->created = $value->created_at->format('d-M-Y');
        }    

         $customer['data'] = $data->toArray();


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

    public function createCustomer($request)
    {
         if ($request['type'] == 2)
            $dob = '';
        elseif ($request['type'] == 1)
            $dob = $request['year'] . '-' . $request['month'] . '-' . $request['day'];


        $customer = Customer::create([
            'type'           => $request['type'],
            'name'           => $request['name'],
            'email'           => $request['email'],
            'user_id'        => $this->current_user->id,
            'dob'            => $dob,
            'company_number' => $request['company_number'],
            'street_name'    => $request['street_name'],
            'street_number'  => $request['street_number'],
            'telephone'      => $request['telephone'],
            'mobile'         => $request['mobile'],
            'postcode'       => $request['postcode'],
            'town'           => $request['town'],
            'image'          => $fileName,
            'status'         => $request['status'],


        ]);
    }

}
