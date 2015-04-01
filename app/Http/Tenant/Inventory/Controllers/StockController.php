<?php namespace App\Http\Tenant\Inventory\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Inventory\Models\Product;
use App\Http\Tenant\Inventory\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends BaseController {

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

   

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    

}
?>
