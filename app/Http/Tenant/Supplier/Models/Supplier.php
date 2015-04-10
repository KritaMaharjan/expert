<?php
namespace App\Http\Tenant\Supplier\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Supplier extends Model {

    protected $table = "fb_suppliers";

    protected $fillable = ['user_id', 'type', 'name', 'email', 'dob', 'street_name', 'street_number', 'postcode', 'town', 'telephone', 'mobile', 'image', 'status'];

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

        $supplier = array();
        $query = $this->select($select);

        if ($orderColumn != '' AND $orderdir != '') {
            $query = $query->orderBy($orderColumn, $orderdir);
        } else {
            $query = $query->orderBy('id', 'desc');
        }

        if ($search != '') {
            $query = $query->where('name', 'LIKE', "%$search%");
        }
        $supplier['total'] = $query->count();


        $query->skip($start)->take($take);

        $data = $query->get();

        foreach ($data as $key => &$value) {
            $value->created = $value->created_at->format('d-M-Y');
            $value->DT_RowId = "row-" . $value->id;
        }

        $supplier['data'] = $data->toArray();

        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $supplier['total'];
        $json->recordsFiltered = $supplier['total'];
        $json->data = $supplier['data'];

        return $json;
    }



    function toData()
    {
        $this->show_url = tenant()->url('supplier/' . $this->id);
        $this->edit_url = tenant()->url('supplier/' . $this->id . '/edit');

        return $this->toArray();
    }

    public function createSupplier($request, $user_id)
    {
        if ($request['type'] == 2)
            $dob = '';
        elseif ($request['type'] == 1)
            $dob = $request['year'] . '-' . $request['month'] . '-' . $request['day'];

        $postal_code = explode(',', $request['postcode']);

        $supplier = Supplier::create([
            'type'           => $request['type'],
            'name'           => $request['name'],
            'email'          => $request['email'],
            'user_id'        => $user_id,
            'dob'            => $dob,
            'street_name'    => $request['street_name'],
            'street_number'  => $request['street_number'],
            'telephone'      => $request['telephone'],
            'mobile'         => $request['mobile'],
            'postcode'       => $postal_code[0],
            'town'           => $request['town'],
            'status'         => $request['status'],
        ]);
        $supplier_add['data'] = $this->toFomatedData($supplier);
        $supplier_add['edit_url'] = tenant()->url('supplier/' . $supplier->id . '/edit');
        $supplier_add['template'] = $this->getTemplate($supplier);

        return $supplier_add;
    }

    public function updateSupplier($id, $details, $dob)
    {

        $postal_code = explode(',', $details['postcode']);

        $supplier = Supplier::where('id', $id)->first();
        $supplier->type = $details['type'];
        $supplier->name = $details['name'];
        $supplier->email = $details['email'];
        $supplier->user_id = current_user()->id;
        $supplier->dob = $dob;
        $supplier->street_name = $details['street_name'];
        $supplier->street_number = $details['street_number'];
        $supplier->telephone = $details['telephone'];
        $supplier->mobile = $details['mobile'];
        $supplier->postcode = $postal_code[0];
        $supplier->town = $details['town'];
        $supplier->status = $details['status'];
        $supplier->save();


        $updated_supplier['data'] = $this->toFomatedData($supplier);
        $updated_supplier['template'] = $this->getTemplate($supplier);
        $updated_supplier['edit_url'] = tenant()->url('supplier/' . $id . '/edit');

        return $updated_supplier;
    }

    public function getTemplate($details = '')
    {
        $details->supplierName = $details->name;

        $details->created = $details->created_at->format('d-M-Y');


        $template = "<td>" . $details->fullname . "</td>
                     <td>" . $details->created . "</td>
                     <td>" . $details->email . "</td>
                     <td>" . $details->status . "</td>";

        return $template;
    }

    function toFomatedData($data)
    {
        foreach ($data as $k => &$items) {
            $this->toArray();
        }

        return $data;
    }
}
