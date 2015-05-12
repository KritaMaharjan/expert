<?php

namespace App\Http\Tenant\Invoice\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Invoice\Models\Bill;
use App\Http\Tenant\Invoice\Models\BillProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use App\Models\Tenant\Setting;

class OfferController extends BaseController {


    protected $bill;
    protected $request;

    public function __construct(Bill $bill, Request $request, Setting $setting)
    {
        \FB::can('Invoice');
        parent::__construct();
        $this->bill = $bill;
        $this->request = $request;
        $this->setting = $setting;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    protected $rules = [
        'customer'        => 'required',
        'due_date' => 'required|date'
    ];


    /**
     * show product manage page
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('tenant.invoice.bill.index')->with('pageTitle', 'All Offers');
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['b.invoice_number', 'b.customer_id', 'b.total', 'b.due_date', 'b.created_at', 'b.status'];
            $json = $this->bill->dataTablePagination($this->request, $select, true);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }

    public function add()
    {
        $c_id = $this->request->input('id');
        if(!empty($c_id)){
               $customer_id = $c_id;
               $customer_details =  \DB::table('fb_customers')->where('id', $c_id)->first();
        }
         
        else
            $customer_id ='';

        $months = \Config::get('tenant.month');         
        $currencies = \Config::get('tenant.currencies');
        $data = array('months' => $months, 'currencies' => \Config::get('tenant.currencies'));
        $company_details = $this->getCompanyDetails();
        return view('tenant.invoice.bill.create', compact('company_details','months','currencies','customer_id','customer_details'))->with('pageTitle', 'Add new offer')->with($data);
    }

    function getCompanyDetails()
    {
        $company = $this->setting->getCompany();
        $business = $this->setting->getBusiness();
        $fix = $this->setting->getFix();
        $company_details = array_merge($company, $business, $fix);
        return $company_details;
    }

    public function create()
    {
        $validator = Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            redirect()->back()->withErrors($validator)->withInput();

        $this->bill->add($this->request, true);

        Flash::success('Offer added successfully!');
        return tenant()->route('tenant.invoice.offer.index');
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

        $bill = $this->bill->billDetails($id);
        if ($bill == null || empty($bill)) {
            show_404();
        }

        $data = array('currencies' => \Config::get('tenant.currencies'));
        $company_details = $this->getCompanyDetails();
        return view('tenant.invoice.bill.edit', compact('bill'))->with('pageTitle', 'Update Offer')->with('company_details', $company_details)->with($data);
    }

    /**  update bill detail
     * @return string
     */
    function update()
    {
        $id = $this->request->route('id');

        $bill = $this->bill->find($id);
        if (empty($bill))
            show_404();

        $validator = Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            redirect()->back()->withErrors($validator)->withInput();

        $this->bill->edit($this->request, $id);

        Flash::success('Offer updated successfully!');
        return tenant()->route('tenant.invoice.offer.index');
    }


    function delete()
    {
        $id = $this->request->route('id');

        $bill = Offer::find($id);
        if (!empty($bill)) {
            if ($bill->delete()) {
                $product_bills = BillProducts::where('bill_id', $id)->get();
                if (!empty($product_bills)) {
                    foreach ($product_bills as $product_bill) {
                        $product_bill->delete();
                    }
                    return $this->success(['message' => 'Offer deleted Successfully']);
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

    function convertToBill()
    {
        $id = $this->request->route('id');
        $bill = $this->bill->convertToBill($id);

        if(!$bill)
            show_404();

        Flash::success('Offer converted to bill successfully!');
        return tenant()->route('tenant.invoice.offer.index');
    }

}
