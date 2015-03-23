<?php namespace App\Http\Tenant\Invoice\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Customer;
use App\Http\Tenant\Invoice\Models\BillProduct;
use App\Http\Tenant\Inventory\Models\Product;
use Illuminate\Support\Facades\DB;

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
    protected $fillable = ['invoice_number', 'customer_id', 'invoice_date', 'currency', 'subtotal', 'tax', 'shipping', 'total', 'paid', 'remaining', 'status', 'account_number', 'due_date'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    function add(Request $request)
    {
        // Start transaction!
        DB::beginTransaction();
        try {
            $bill = Bill::create([
                'invoice_number' => $request->input('invoice_number'),
                'customer_id' => $request->input('customer_id'),
                'invoice_date' => $request->input('invoice_date'),
                'due_date' => $request->input('due_date'),
                'account_number' => $request->input('account_number'),
                'currency' => $request->input('currency'),
            ]);

            $products = $request->input('product');
            $quantity = $request->input('quantity');

            $alltotal = 0;
            $subtotal = 0;
            $tax = 0;

            foreach($products as $key => $product)
            {
                if(isset($quantity[$key]) && $quantity[$key] > 0 && $product > 0) {
                    $product_details = Product::find($product);
                    $total = ($product_details->selling_price + $product_details->vat * 0.01 * $product_details->selling_price) * $quantity[$key];
                    $product_bill = BillProduct::create([
                        'product_id' => $product,
                        'bill_id' => $bill->id,
                        'quantity' => $quantity[$key],
                        'price' => $product_details->selling_price,
                        'vat' => $product_details->vat,
                        'total' => $total
                    ]);
                    $alltotal += $total;
                    $tax += $product_details->vat * 0.01 * $product_details->selling_price * $quantity[$key];
                    $subtotal += $product_details->selling_price * $quantity[$key];
                }

            }

            $bill->subtotal = $subtotal;
            $bill->tax = $tax;
            $bill->total = $alltotal;
            $bill->save();

            DB::commit();
            return array('bill_details' => $bill);

        } catch(\Exception $e) {
            DB::rollback();
            throw $e;
        }
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

            $value->invoice_date = date('d-M-Y  h:i:s A', strtotime($value->invoice_date));
            //$value->created_at->format('d-M-Y  h:i:s A');
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
