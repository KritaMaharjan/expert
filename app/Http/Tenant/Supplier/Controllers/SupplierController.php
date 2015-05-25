<?php
namespace App\Http\Tenant\Supplier\Controllers;

use App\Http\Tenant\Supplier\Models\Supplier;
use App\Http\Tenant\Invoice\Models\Bill;
use App\Http\Controllers\Tenant\BaseController;
use Illuminate\Http\Request;
use Input;
use Session;
use App\Http\Tenant\Email\Models\Email;
use App\Http\Tenant\Email\Models\Receiver;

class SupplierController extends BaseController {


    protected $request;
    protected $supplier;
    protected $email;

    public function __construct(Supplier $supplier, Request $request, Bill $bill,Email $email,Receiver $receiver)
    {
        \FB::can('Invoice');
        parent::__construct();
        $this->supplier = $supplier;
        $this->request = $request;
        $this->bill = $bill;
        $this->email = $email;
        $this->receiver = $receiver;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $months = \Config::get('tenant.month');
        $data = array('months' => $months);
        return view('tenant.supplier.supplier')->withPageTitle('Supplier')->with($data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $validator = \Validator::make($this->request->all(),
            array(
                'name'          => 'required|between:2,30',
                'email'         => 'required|unique:fb_suppliers',
                'telephone'     => 'numeric|unique:fb_suppliers,telephone',
                'mobile'        => 'numeric|unique:fb_suppliers,telephone',
                'postcode'      => 'required|numeric'
            )
        );

        if ($validator->fails())
            return \Response::json(array('status' => 'fail', 'errors' => $validator->getMessageBag()->toArray()));
        $result = $this->supplier->createSupplier($this->request, $this->current_user->id);
        $redirect_url = tenant_route('tenant.supplier.index');

        return \Response::json(array('success' => true, 'data' => $result['data'], 'template' => $result['template'], 'edit_url' => $result['edit_url'], 'redirect_url' => $redirect_url));

    }

    function edit()
    {
        $id = $this->request->route('id');
        $months = \Config::get('tenant.month');
        $supplier = $this->supplier->find($id);
        if ($supplier == null) {
            show_404();
        }

        return view('tenant.supplier.editSupplier', compact('supplier', 'months'));
    }

    public function testUpload(Request $request)
    {
        $uploaded_file = (Input::file('file'));
        $file = \FB::uploadFile($uploaded_file);
        if ($file)
            return \Response::json(array('status' => 'success', 'file' => $file));
    }

    function update()
    {
        $id = $this->request->route('id');
        $supplier1 = $this->supplier->find($id);

        if (empty($supplier1))
            return $this->fail(['error' => 'Invalid Supplier ID']);


        if ($this->request['business'])
            $dob = '';
        else
            $dob = $this->request['year'] . '-' . $this->request['month'] . '-' . $this->request['day'];

        $validator = \Validator::make($this->request->all(),
            array(
                'name'          => 'required|between:2,30',
                'email'         => 'required',
                'dob'           => '',
                'telephone'     => 'numeric|unique:fb_suppliers,telephone,'.$id,
                'mobile'        => 'numeric|unique:fb_suppliers,mobile,'.$id,
                'postcode'      => 'required|numeric',
                'street_number' => 'max:200',
            )
        );

        if ($validator->fails())
            return \Response::json(array('status' => 'fail', 'errors' => $validator->getMessageBag()->toArray()));

       
        $suppliers = $this->supplier->updateSupplier($id, $this->request, $dob, $this->current_user->id);

        $redirect_url = tenant_route('tenant.supplier.index');

        return \Response::json(array('success' => true, 'data' => $suppliers['data'], 'template' => $suppliers['template'], 'edit_url' => $suppliers['edit_url'], 'redirect_url' => $redirect_url));
    }

    function invoices(){
        if ($this->request->ajax()) {
            $select = ['id', 'total', 'due_date', 'status'];
            $supplier_id = Session::get('supplier_id');
            $json = $this->bill->dataTablePaginationSupplier($this->request, $select,$supplier_id);
           Session::forget('supplier_id');
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'name', 'email', 'created_at'];

            $json = $this->supplier->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }


    public function deleteSupplier()
    {
        $id = $this->request->route('id');
        $supplier = $this->supplier->find($id);
        if (!empty($supplier)) {
            if ($supplier->delete()) {
                return $this->success(['message' => 'Supplier deleted Successfully']);
            }
        }

        return $this->fail(['message' => 'Something went wrong. Please try again later']);

    }

    public function changeStatus()
    {
        $supplier_id = Input::get('cus_id');
        $status = Input::get('status');

        $supplier = $this->supplier->find($supplier_id);
        if (!empty($supplier)) {
            $supplier->status = $status;
            $supplier->save();

            return \Response::json(array('status' => true));
        }

        return $this->fail(['message' => 'Something went  wrong. Please try again later']);

    }

    public function upload()
    {

        $file = Input::file('file');

        $input = array('image' => $file);

        $rules = array(
            'image' => 'image'
        );
        $validator = \Validator::make($input, $rules);
        if ($validator->fails()) {
            return \Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);

        } else {
            $destinationPath = 'uploads/';
            $filename = $file->getClientOriginalName();
            \Input::file('image')->move($destinationPath, $filename);

            return \Response::json(['success' => true, 'file' => asset($destinationPath . $filename)]);
        }

    }

    public function getSupplierSuggestions()
    {
        $name = \Input::get('name');
        //change this later
        $details = Supplier::where('name', 'LIKE', '%' . $name . '%')->get();
        $newResult = array();

        if (!empty($details)) {

            foreach ($details as $d) {
                $new = array();
                $new['id'] = $d->id;
                $new['text'] = $d->name;
                array_push($newResult, $new);
            }
        }

        return $newResult;
    }

    public function getSupplierDetails()
    {
        $supplier_id = $this->request->route('supplierId');
        $supplier = Supplier::find($supplier_id);
        $supplier->paymentNo = $this->bill->getSupplierPayment($supplier_id);
        $supplier->invoiceNo = $this->bill->getPrecedingInvoiceNumber($supplier_id);

        return \Response::json(['success' => true, 'details' => $supplier]);
    }


}
