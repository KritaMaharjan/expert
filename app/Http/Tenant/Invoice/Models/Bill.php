<?php

namespace App\Http\Tenant\Invoice\Models;

use App\Http\Tenant\Accounting\Libraries\Record;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Customer;
use App\Http\Tenant\Invoice\Models\BillProducts;
use App\Http\Tenant\Inventory\Models\Product;
use Illuminate\Support\Facades\DB;

class Bill extends Model {


    const TYPE_BILL = 0;
    const TYPE_OFFER = 1;

    const STATUS_UNPAID = 0;
    const STATUS_PAID = 1;
    const STATUS_PARTIAL_PAID = 2;


    const STATUS_ACTIVE = 0;
    const STATUS_COLLECTION = 1;
    const STATUS_LOSS = 2;
    const STATUS_CREDITED = 3;

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
    protected $fillable = ['invoice_number', 'customer_id', 'currency', 'subtotal', 'tax', 'shipping', 'total', 'paid', 'remaining', 'payment', 'full_payment_date', 'status', 'due_date', 'type', 'is_offer', 'customer_payment_number', 'vat'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function customer()
    {
        return $this->belongsTo('App\Models\Tenant\Customer');
    }


    function payments()
    {
        return $this->hasMany('App\Http\Tenant\Invoice\Models\BillPayment');
    }

    function add(Request $request, $offer = false)
    {
        // Start transaction!
        DB::beginTransaction();
        try {
            $customer_id = $request->input('customer');
            $vat = $request->input('vat');

            $bill = Bill::create([
                'invoice_number' => $this->getPrecedingInvoiceNumber($customer_id),
                'customer_id'    => $customer_id,
                'due_date'       => $request->input('due_date'),
                'currency'       => $request->input('currency'),
                'vat'            => $vat,
                'is_offer'       => ($offer == true) ? self::TYPE_OFFER : self::TYPE_BILL,
                'type'       => ($offer == true) ? self::TYPE_OFFER : self::TYPE_BILL,
            ]);

            $products = $request->input('product');
            $quantity = $request->input('quantity');

            $alltotal = 0;
            $subtotal = 0;
            $tax = 0;
            foreach ($products as $key => $product) {
                if (isset($quantity[$key]) && $quantity[$key] > 0 && $product > 0) {
                    $product_details = Product::find($product);
                    $total = ($product_details->selling_price + $vat * 0.01 * $product_details->selling_price) * $quantity[$key];
                    //$total = ($product_details->selling_price + $product_details->vat * 0.01 * $product_details->selling_price) * $quantity[$key];
                    $product_bill = BillProducts::create([
                        'product_id' => $product,
                        'bill_id'    => $bill->id,
                        'quantity'   => $quantity[$key],
                        'price'      => $product_details->selling_price,
                        //'vat' => $product_details->vat,
                        'total'      => $total
                    ]);
                    $alltotal += $total;
                    $tax += $vat * 0.01 * $product_details->selling_price * $quantity[$key];
                    //$tax += $product_details->vat * 0.01 * $product_details->selling_price * $quantity[$key];
                    $subtotal += $product_details->selling_price * $quantity[$key];
                }

            }

            //$bill->invoice_number = $this->getPrecedingInvoiceNumber($bill->id);
            $bill->subtotal = $subtotal;
            $bill->vat_amount = $tax;
            $bill->total = $alltotal;
            $bill->remaining = $alltotal;
            $bill->customer_payment_number = format_id($bill->customer_id) . format_id($bill->id);
            $bill->save();

            DB::commit();

            if ($offer != true) {
                $customer = Customer::find($customer_id);
                Record::sendABill($bill, $customer, $alltotal, $vat);
            }

            return array('bill_details' => $bill);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    function edit(Request $request, $id)
    {
        // Start transaction!
        DB::beginTransaction();
        try {
            $bill = Bill::find($id);
            $bill->customer_id = $request->input('customer');
            $bill->due_date = $request->input('due_date');
            $bill->currency = $request->input('currency');
            $bill->save();

            $products = $request->input('product');
            $quantity = $request->input('quantity');

            $alltotal = 0;
            $subtotal = 0;
            $tax = 0;

            $this->deleteBillProducts($id);

            foreach ($products as $key => $product) {
                if (isset($quantity[$key]) && $quantity[$key] > 0 && $product > 0) {
                    $product_details = Product::find($product);
                    $total = ($product_details->selling_price + $product_details->vat * 0.01 * $product_details->selling_price) * $quantity[$key];
                    $product_bill = BillProducts::create([
                        'product_id' => $product,
                        'bill_id'    => $bill->id,
                        'quantity'   => $quantity[$key],
                        'price'      => $product_details->selling_price,
                        'vat'        => $product_details->vat,
                        'total'      => $total
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

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    function deleteBillProducts($id)
    {
        $product_bills = BillProducts::where('bill_id', $id)->get();
        if (!empty($product_bills)) {
            foreach ($product_bills as $product_bill) {
                $product_bill->delete();
            }

            return true;
        }

        return false;
    }


    function dataTablePagination(Request $request, array $select = array(), $is_offer = false)
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
        array_push($select, 'c.name');
        array_push($select, 'b.id');

        $query = $this->from('fb_bill as b')->select($select)->join('fb_customers as c', 'b.customer_id', '=', 'c.id');

        if ($is_offer == true)
            $query = $query->where('is_offer', 1);
        else
            $query = $query->where('is_offer', 0);

        if ($orderColumn != '' AND $orderdir != '') {
            if ($orderColumn != 'invoice_date')
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
            $value->total = number_format($value->total, 2);
            $value->invoice_number = '<a class="link" href="#">' . $value->invoice_number . '</a>';
            //$customer = Customer::find($value->customer_id);
            //if ($customer)
            $value->customer = $value->name;
            //else $value->customer = 'Undefined';
            $value->raw_status = $value->status;

            $value->status = $this->getStatus($value->status, $value->payment);
            $value->invoice_date = $value->created_at->format('d-M-Y  h:i:s A');
            $value->view_url = tenant()->url('invoice/bill/' . $value->id);
            $value->DT_RowId = "row-" . $value->guid;
        }

        $products['data'] = $data->toArray();

        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $products['total'];
        $json->recordsFiltered = $products['total'];
        $json->data = $products['data'];

        return $json;
    }

    function getStatus($status, $payment)
    {
        if ($status == static::STATUS_ACTIVE)
        {
            if ($payment == static::STATUS_PAID)
                $status = '<span class="label label-success">Paid</span>';
            elseif ($payment == static::STATUS_PARTIAL_PAID)
                $status = '<span class="label label-warning">Partially Paid</span>';
            elseif ($payment == static::STATUS_UNPAID)
                $status = '<span class="label label-danger">Unpaid</span>';
        }
        elseif ($status == static::STATUS_COLLECTION)
            $status = '<span class="label label-warning">Collection</span>';
        elseif ($status == static::STATUS_LOSS)
            $status = '<span class="label label-danger">Loss</span>';
        elseif ($status == static::STATUS_CREDITED)
            $status = '<span class="label label-danger">Credited</span>';

        return $status;
    }

    function billDetails($id = '')
    {
        $bill = Bill::find($id);

        if ($bill != null) {
            $customer = Customer::find($bill->customer_id);
            $bill->customer = $customer->name;
            $bill->customer_details = $customer;

            $bill_products = BillProducts::where('bill_id', $id)->get();
            if ($bill_products) {
                foreach ($bill_products as $bill_product) {
                    $bill_product->product_name = Product::find($bill_product->product_id)->name;
                }
                $bill->products = $bill_products;
            }

            return $bill;
        }

        return false;
    }

    function getPrecedingInvoiceNumber($customer_id)
    {
        $today = \Carbon::now()->format('Y-m-d');
        $latest_count = Bill::select('id')->where('customer_id', $customer_id)->where('created_at', '>', $today)->count();
        //$latest = Bill::select('id')->where('customer_id',$customer_id)->orderBy('id', 'desc')->first();
        if ($latest_count)
            $new_invoice_num = date('dmy') . format_id($customer_id) . '-' . ($latest_count + 1);
        else
            $new_invoice_num = date('dmy') . format_id($customer_id) . '-1';

        return $new_invoice_num;
    }

    function getCustomerPayment($id = null)
    {
        $latest = Bill::select('id')->orderBy('id', 'desc')->first();
        if ($latest)
            $new_cus_no = format_id($id, 3) . sprintf("%03d", ($latest->id + 1));
        else
            $new_cus_no = format_id($id, 3) . '001';

        return $new_cus_no;
    }

    function convertToBill($id)
    {
        $bill = Bill::find($id);
        if ($bill) {
            $bill->type = self::TYPE_BILL;
            $bill->is_offer = 0;
            $bill->save();

            return $bill;
        } else
            return false;
    }

    function getCustomerBill($customer_id)
    {
        $bills = Bill::where('customer_id', $customer_id)->get();
        $invoices = array();
        $totalbills = 0;
        $totaloffers = 0;
        foreach ($bills as $key => $value) {
            if ($value->is_offer == 0) {
                $totalbills += $value->total;
            } else if ($value->is_offer == 1) {
                $totaloffers += $value->total;
            }
        }

        $invoices['bills'] = $bills;
        $invoices['totalbills'] = $totalbills;
        $invoices['totaloffers'] = $totaloffers;

        return $invoices;

    }

    function creditBill($id)
    {
        $bill = Bill::find($id);
        if(!empty($bill))
        {
            $bill->status = static::STATUS_CREDITED;;
            $bill->save();
            $customer = Customer::find($bill->customer_id);
            Record::billCredit($bill, $customer, $bill->remaining, $bill->vat);
            return true;
        }
        return false;
    }

    function dataTablePaginationCustomer(Request $request, array $select = array(), $customer_id)
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

        $invoices = array();
        $query = $this->select($select);

        // if ($is_offer == true)
        //     $query = $query->where('is_offer', 1);
        // else
        //     $query = $query->where('is_offer', 0);

        if ($orderColumn != '' AND $orderdir != '') {
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        if ($search != '') {
            $query = $query->where('invoice_number', 'LIKE', "%$search%");
        }
        $invoices['total'] = $query->where('customer_id', $customer_id)->count();


        $query->skip($start)->take($take);

        $data = $query->where('customer_id', $customer_id)->get();

        foreach ($data as $key => &$value) {

            $value->total = number_format($value->total, 2);

            $value->raw_status = $value->status;
            if ($value->status == 1)
                $value->status = '<span class="label label-success">Paid</span>';
            elseif ($value->status == 2)
                $value->status = '<span class="label label-warning">Collection</span>';
            else
                $value->status = '<span class="label label-danger">Unpaid</span>';

            $value->invoice_date = date('d-M-Y  h:i:s A', strtotime($value->created_at));

            $value->DT_RowId = "row-" . $value->guid;
        }

        $invoices['data'] = $data->toArray();

        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $invoices['total'];
        $json->recordsFiltered = $invoices['total'];
        $json->data = $invoices['data'];

        return $json;
    }
}
