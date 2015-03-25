<?php namespace App\Http\Tenant\Inventory\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Inventory\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController {


    protected $product;
    protected $request;

    public function __construct(Product $product, Request $request)
    {
        \FB::can('Inventory');
        parent::__construct();
        $this->product = $product;
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
        return view('tenant.inventory.product.index');
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'name', 'number', 'selling_price', 'purchase_cost', 'vat'];
            $json = $this->product->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
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
    function detail()
    {
        if (!$this->request->ajax()) return show_404();

        $id = $this->request->route('id');
        $product = $this->product->find($id);
        if ($product == null) {
            show_404();
        }

        if ($this->request->input('json') == 1) {
            return $this->success($product->toArray());
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

        $product = $this->product->find($id);
        if ($product == null) {
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

        $product = $this->product->find($id);

        if (empty($product))
            return $this->fail(['error' => 'Invalid Product ID']);

        if ($product->name == $this->request->input('name')) {
            unset($this->rules['name']);
        }

        if ($product->number == $this->request->input('number')) {
            unset($this->rules['number']);
        }

        $validator = Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return $this->fail(['errors' => $validator->messages()]);

        $product->number = $this->request->input('number');
        $product->name = $this->request->input('name');
        $product->vat = $this->request->input('vat');
        $product->selling_price = $this->request->input('selling_price');
        $product->purchase_cost = $this->request->input('purchase_cost');
        $product->save();
        $result = $product->toData();

        return ($result) ? $this->success($result) : $this->fail(['errors' => 'something went wrong']);
    }


    function delete()
    {
        $id = $this->request->route('id');

        $product = $this->product->find($id);
        if (!empty($product)) {
            if ($product->delete()) {
                return $this->success(['message' => 'Product deleted Successfully']);
            }
        }

        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }

    public function getSuggestions()
    {
        if ($this->request->ajax()) {
            $name = $this->request->input('name');
<<<<<<< HEAD
            $products = $this->product->select('id', 'name as text')->where('name', 'LIKE',  $name . '%')->get()->toJson();
=======
            $products = $this->product->select('id', 'name as text')->where('name', 'LIKE', $name . '%')->get()->toJson();
>>>>>>> e4115d1b5f36e13a12d0e8094cf5def2795aaa64

            return $products;
        }

    }
}
