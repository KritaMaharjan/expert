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
            $value->name = "<a href=".tenant_route('tenant.customer.CustomerCard', $value->id).">".$value->name."</a>";
           $value->email = $value->email;
            $value->created = $value->created_at->format('d-M-Y');
              $value->DT_RowId = "row-".$value->id;
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

    public function createCustomer($request,$user_id,$fileName)
    {
         if ($request['type'] == 2)
            $dob = '';
        elseif ($request['type'] == 1)
            $dob = $request['year'] . '-' . $request['month'] . '-' . $request['day'];


        $customer = Customer::create([
            'type'           => $request['type'],
            'name'           => $request['name'],
            'email'           => $request['email'],
            'user_id'        => $user_id,
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
          $customer_add['data'] = $this->toFomatedData($customer);
        $customer_add['template'] = $this->getTemplate($customer);

        return $customer_add;
    }

     public function updateCustomer($id,$details,$dob,$fileName)
    {
         
        $customer = Customer::where('id', $id)->first();
        $customer->type = $details['type'];
        $customer->name = $details['name'];
        $customer->email = $details['email'];
        $customer->user_id = current_user()->id;
        $customer->dob = $dob;
        $customer->company_number = $details['company_number'];
        $customer->street_name = $details['street_name'];
        $customer->street_number = $details['street_number'];
        $customer->telephone = $details['telephone'];
        $customer->mobile = $details['mobile'];
        $customer->postcode = $details['postcode'];
        $customer->town = $details['town'];
        $customer->image = $fileName;
        $customer->status = $details['status'];
        $customer->save();

 
        $updated_customer['data'] = $this->toFomatedData($customer);
        $updated_customer['template'] = $this->getTemplate($customer);
        $updated_customer['show_url'] = tenant()->url('customer/CustomerCard/'.$id);
        $updated_customer['edit_url'] = tenant()->url('customer/' . $id . '/edit');
     
        return $updated_customer;
    }

    

     public function getTemplate($details='')
    {
        $details->name =  "<a href=".tenant_route('tenant.customer.CustomerCard', $details->id).">".$details->name."</a>";
       
        $details->created = $details->created_at->format('d-M-Y');


        $template = "<td>".$details->fullname."</td>
                     <td>".$details->created."</td>
                     <td>".$details->email."</td>
                     <td>".$details->status."</td>";
        return $template;
    }

     function toFomatedData($data)
    {
        foreach($data as $k => &$items)
        {
            $this->toArray();
        }

       return $data;
    }


   
}
