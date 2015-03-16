<?php namespace App\Http\Tenant\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Inventory extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_inventory';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'user_id', 'quantity', 'selling_price', 'purchase_cost', 'vat', 'purchase_date'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    function add(Request $request)
    {
        $product_id = $request->input('product_id');
        $product = Product::find($product_id);

        $inventory = Inventory::create([
            'product_id'    => $product->id,
            'quantity'      => $request->input('quantity'),
            'purchase_date' => $request->input('purchase_date'),
            'selling_price' => $product->selling_price,
            'purchase_cost' => $product->purchase_cost,
            'vat'           => $product->vat,
            'user_id'       => current_user()->id
        ]);


        return $inventory->toData();
    }

    function totalSellingPrice()
    {


        return $this->convertToCurrency($this->selling_price * $this->quantity);
    }

    function totalPurchaseCost()
    {
        return $this->convertToCurrency($this->purchase_cost * $this->quantity);
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


    function toData()
    {
        $this->show_url = tenant()->url('inventory/' . $this->id);
        $this->edit_url = tenant()->url('inventory/' . $this->id . '/edit');
        $this->selling_price = $this->totalSellingPrice();
        $this->purchase_cost = $this->totalPurchaseCost();
        $this->vat = $this->vat();

        return $this->toArray();
    }

    function convertToCurrency($num)
    {
        return '$' . number_format($num, 2);
    }

    function dataTablePagination(Request $request, $select)
    {
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
        $query = $this->select($select)
            ->from('fb_inventory as i')
            ->leftJoin('fb_products as p', 'p.id', '=', 'i.product_id');

        if ($orderColumn != '' AND $orderdir != '') {
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        if ($search != '') {
            $query = $query->where('p.name', 'LIKE', "%$search%");
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

}
