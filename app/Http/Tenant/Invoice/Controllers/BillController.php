<?php

namespace App\Http\Tenant\Invoice\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Invoice\Models\Bill;
use App\Http\Tenant\Invoice\Models\ProductBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillController extends BaseController {


    protected $bill;
    protected $request;

    public function __construct(Bill $bill, Request $request)
    {
        \FB::can('Invoice');
        parent::__construct();
        $this->bill = $bill;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    protected $rules = [
        'customer_id'        => 'required',
        'invoice_date'          => 'required|date',
        'invoice_number'           => 'required|numeric|unique:fb_bill',
        'due_date' => 'required|date',
        'account_number' => 'required',
    ];


    /**
     * show product manage page
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('tenant.invoice.bill.index');
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'invoice_number', 'customer_id', 'total', 'due_date', 'created_at', 'invoice_date', 'status'];
            $json = $this->bill->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }

    public function add()
    {
        return view('tenant.invoice.bill.create');
    }

    public function create()
    {
        $validator = Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            redirect()->back()->withErrors($validator)->withInput();

        $this->bill->add($this->request);
        return tenant()->route('tenant.invoice.bill.index');
    }


    /**
     * Display product detail
     * @return string
     */
    function show()
    {
        $id = $this->request->route('id');
        $bill = $this->bill->find($id);
        if ($bill == null) {
            show_404();
        }

        if($this->request->ajax())
        {
            return $this->success($bill->toArray());
        }
        return view('tenant.inventory.product.show', compact('product'));

    }


    /**
     * display edit form
     * @return string
     */
    function edit()
    {
        $id = $this->request->route('id');

        $bill = $this->bill->find($id);
        if ($bill == null) {
            show_404();
        }

        return view('tenant.inventory.product.edit', compact('product'));
    }

    /**  update product detail
     * @return string
     */
    function update()
    {
        $id = $this->request->route('id');

        $bill = $this->bill->find($id);

        if (empty($bill))
            return $this->fail(['error' => 'Invalid Product ID']);

        if ($bill->name == $this->request->input('name')) {
            unset($this->rules['name']);
        }

        if ($bill->number == $this->request->input('number')) {
            unset($this->rules['number']);
        }

        $validator = Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return $this->fail(['errors' => $validator->messages()]);

        $bill->number = $this->request->input('number');
        $bill->name = $this->request->input('name');
        $bill->vat = $this->request->input('vat');
        $bill->selling_price = $this->request->input('selling_price');
        $bill->purchase_cost = $this->request->input('purchase_cost');
        $bill->save();
        $result = $bill->toData();

        return ($result) ? $this->success($result) : $this->fail(['errors' => 'something went wrong']);
    }


    function delete()
    {
        $id = $this->request->route('id');

        $bill = Bill::find($id);
        if (!empty($bill)) {
            if ($bill->delete()) {
                $product_bills = ProductBill::where('bill_id', $id)->get();
                if (!empty($product_bills)) {
                    foreach ($product_bills as $product_bill) {
                        $product_bill->delete();
                    }
                    return $this->success(['message' => 'Bill deleted Successfully']);
                }
            }
        }

        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }

    public function getSuggestions()
    {
        $name = \Input::get('name');
        //change this later
        $details = Product::where('name', 'LIKE', '%'.$name.'%')->get();
        $newResult = array();

        if(!empty($details)) {

            foreach($details as $d) {
                $new = array();
                $new['id'] = $d->id;
                $new['text'] = $d->name;
                array_push($newResult, $new);
            }
        }

        return $newResult;
    }

}
