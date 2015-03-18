<?php namespace App\Http\Tenant\Email\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Email\Models\Product;
use App\Http\Tenant\Email\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends BaseController {

  
    protected $request;

    public function __construct(Request $request)
    {
        parent::__construct();
      
        $this->request = $request;
    }

    protected $rules = [
        
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
       return 'email';
    }
}