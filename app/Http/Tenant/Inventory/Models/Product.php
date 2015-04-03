<?php namespace App\Http\Tenant\Inventory\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

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
        $this->show_url = tenant()->url('inventory/product/' . $this->id. '/detail');
        $this->edit_url = tenant()->url('inventory/product/' . $this->id . '/edit');
        $this->purchase_cost = $this->purchase_cost();
        $this->selling_price = $this->selling_price();
        $this->vat = $this->vat();
        $this->is_inventory = $this->in_inventory($this->id);

        return $this->toArray();
    }

    function in_inventory($product_id){
        $inventory = \DB::table('fb_inventory')->where('product_id', $product_id)->first();
        return $inventory;

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
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        if ($search != '') {
            $query = $query->where('name', 'LIKE', "%$search%");
        }
        $products['total'] = $query->count();


        $query->skip($start)->take($take);

        $products['data'] = $this->toFomatedData($query->get());

        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $products['total'];
        $json->recordsFiltered = $products['total'];
        $json->data = $products['data'];

        return $json;
    }

    function toFomatedData($data)
    {
        foreach ($data as $k => &$items) {
            $items->toData();
        }

        return $data;
    }

    function get_product(){
        $perpage = 10;
        $products = Product::paginate($perpage);
        $total = 0;
         $total_bill = 0;
        foreach ($products as $key => &$value) {
            $inventory = Inventory::where('product_id',$value->id)->get();
            foreach ($inventory as $key => $inv) {
                $total += $inv->quantity;


            }
            $bill = \DB::table('fb_bill_products')->where('product_id',$value->id)->get();
             foreach ($bill as $key => $pro) {
                $total_bill += $pro->quantity;


            }
            
            $value->total_product = $total; 
             $value->total_bill = $total_bill; 
             $value->remaining = $total - $total_bill; 
        }

        return $products;
       
    }




}
