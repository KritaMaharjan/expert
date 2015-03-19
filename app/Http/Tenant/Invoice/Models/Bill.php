<?php namespace App\Http\Tenant\Invoice\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Customer;

class Bill extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_bill';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['invoice_number', 'customer_id', 'subtotal', 'tax', 'shipping', 'total', 'paid', 'remaining', 'status', 'account_number', 'due_date'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    function add(Request $request)
    {
        $product = new Product();
        $product->number = $request->input('number');
        $product->name = $request->input('name');
        $product->vat = $request->input('vat');
        $product->selling_price = $request->input('selling_price');
        $product->purchase_cost = $request->input('purchase_cost');
        $product->user_id = current_user()->id;
        $product->save();

        return $product->toData();
    }

    function scopeLatest($query)
    {
        $query->orderBY('created_at', 'DESC');
    }

    function selling_price()
    {
        return $this->convertToCurrency($this->selling_price);
    }

    function vat()
    {
        return $this->vat . '%';
    }

    function purchase_cost()
    {
        return $this->convertToCurrency($this->purchase_cost);
    }

    function convertToCurrency($num)
    {
        return '$' . number_format($num, 2);
    }

    function toData()
    {
        $this->show_url = tenant()->url('inventory/product/' . $this->id);
        $this->edit_url = tenant()->url('inventory/product/' . $this->id . '/edit');
        $this->purchase_cost = $this->purchase_cost();
        $this->selling_price = $this->selling_price();
        $this->vat = $this->vat();

        return $this->toArray();
    }


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

        $products = array();
        $query = $this->select($select);

        if ($orderColumn != '' AND $orderdir != '') {
            if($orderColumn != 'invoice_date')
                $query = $query->orderBy($orderColumn, $orderdir);
            else
                $query = $query->orderBy('created_at', $orderdir);
        }

        if ($search != '') {
            $query = $query->where('invoice_number', 'LIKE', "%$search%");
        }
        $products['total'] = $query->count();


        $query->skip($start)->take($take);

        $data = $query->get();

        foreach ($data as $key => &$value) {
            $value->invoice_number = '<a class="link" href="#">'.$value->invoice_number.'</a>';
            $customer = Customer::find($value->customer_id);
            if($customer)
                $value->customer = $customer->name;
            else $value->customer = 'Undefined';
            $value->raw_status = $value->status;
            if($value->status == 1)
                $value->status = '<span class="label label-success">Paid</span>';
            elseif($value->status == 2)
                $value->status = '<span class="label label-warning">Collection</span>';
            else
                $value->status = '<span class="label label-danger">Unpaid</span>';

            $value->invoice_date = $value->created_at->format('d-M-Y  h:i:s A');
            $value->DT_RowId = "row-".$value->guid;
        }

        $products['data'] = $data->toArray();

        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $products['total'];
        $json->recordsFiltered = $products['total'];
        $json->data = $products['data'];

        return $json;
    }


}
