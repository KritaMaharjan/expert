<?php

namespace App\Http\Tenant\Invoice\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Invoice\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillController extends BaseController {


    protected $bill;
    protected $request;

    public function __construct(Bill $bill, Request $request)
    {
        \FB::can('Invoice');
        parent::__construct();
        $this->product = $bill;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    protected $rules = [
        'number'        => 'required|alpha_dash|max:25|unique:fb_products',
        'name'          => 'required|string|max:100|unique:fb_products',
        'vat'           => 'required|numeric|max:99',
        'selling_price' => 'required|numeric|min:1|max:9999999999',
        'purchase_cost' => 'required|numeric|min:1|max:999999999',
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
            $select = ['id', 'bill_number', 'customer_id', 'total', 'due_date', 'created_at', 'status'];
            $json = $this->product->dataTablePagination($this->request, $select);
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
            return $this->fail(['errors' => $validator->getMessageBag()]);

        $result = $this->product->add($this->request);

        return ($result) ? $this->success($result) : $this->fail(['errors' => 'something went wrong']);
    }


    /**
     * Display product detail
     * @return string
     */
    function show()
    {
        $id = $this->request->route('id');
        $bill = $this->product->find($id);
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

        $bill = $this->product->find($id);
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

        $bill = $this->product->find($id);

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

        $bill = $this->product->find($id);
        if (!empty($bill)) {
            if ($bill->delete()) {
                return $this->success(['message' => 'Product deleted Successfully']);
            }
        }

        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }



}
