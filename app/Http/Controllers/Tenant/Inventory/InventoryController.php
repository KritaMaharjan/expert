<?php namespace App\Http\Controllers\Tenant\Inventory;

use App\Http\Controllers\Tenant\BaseController;
use App\Models\Tenant\Product;
use App\Models\Tenant\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends BaseController {

    protected $product;
    protected $request;

    public function __construct(Inventory $inventory, Product $product, Request $request)
    {
        \FB::can('Inventory');
        
        parent::__construct();
        $this->product = $product;
        $this->inventory = $inventory;
        $this->request = $request;
    }

    protected $rules = [
        'product_id'    => 'required|numeric',
        'quantity'      => 'required|numeric|min:1|max:999999999',
        'purchase_date' => 'required|date'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $product_list = $this->product->lists('name', 'id');

        return view('tenant.inventory.main.index', compact('product_list'));
    }

    /**
     * Add new inventory
     * @param Request $request
     * @return mixed
     */
    public function create()
    {
        $validator = Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return $this->fail(['errors' => $validator->messages()]);

        $result = $this->inventory->add($this->request);
        
        $result['name'] = Product::find($result['product_id'])->name;
        return ($result) ? $this->success($result) : $this->fail(['errors' => 'something went wrong']);
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = \DB::raw('id, (select name from fb_products where id = product_id) as name, quantity, selling_price as total_selling_price, purchase_cost as total_purchase_cost, vat, purchase_date');
            $json = $this->inventory->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }


    /**
     * Display inventory detail
     * @return string
     */
    function show()
    {
        $id = $this->request->route('id');

        $inventory = $this->inventory->find($id);
        if ($inventory == null) {
            show_404();
        }

        return view('tenant.inventory.main.show', compact('inventory'));
    }


    /**
     * display edit form
     * @return string
     */
    function edit($id)
    {

       $id = $this->request->route('id');

        $inventory = $this->inventory->find($id);
        if ($inventory == null) {
            show_404();
        }
        $product_list = $this->product->lists('name', 'id');

        return view('tenant.inventory.main.edit', compact('inventory', 'product_list'));
    }

    /**  update inventory detail
     * @return string
     */
    function update()
    {
        $id = $this->request->route('id');

        $inventory = $this->inventory->find($id);

        if (empty($inventory))
            return $this->fail(['error' => 'Invalid inventory ID']);

        $validator = Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return $this->fail(['errors' => $validator->messages()]);

        $inventory->product_id = $this->request->input('product_id');
        $inventory->vat = $this->request->input('vat');
        $inventory->quantity = $this->request->input('quantity');
        $inventory->purchase_date = $this->request->input('purchase_date');
        $inventory->selling_price = $this->request->input('selling_price');
        $inventory->purchase_cost = $this->request->input('purchase_cost');
        $inventory->save();

        foreach ($inventory as $key => $value) {
            $inventory->name = Product::find($inventory->product_id)->name;
        }

        $result = $inventory->toData();

        return ($result) ? $this->success($result) : $this->fail(['errors' => 'something went wrong']);
    }


    function delete()
    {
        $id = $this->request->route('id');

        $inventory = $this->inventory->find($id);
        if (!empty($inventory)) {
            if ($inventory->delete()) {
                return $this->success(['message' => 'Inventory deleted Successfully']);
            }
        }

        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }
}
