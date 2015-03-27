<?php
namespace App\Http\Controllers\Tenant\Customer;

use App\Http\Tenant\Invoice\Models\Bill;
use App\Models\Tenant\Customer;
use App\Http\Controllers\Tenant\BaseController;
use Illuminate\Http\Request;
use Input;
use App\Http\Tenant\Email\Models\Email;
use App\Http\Tenant\Email\Models\Attachment;
use App\Http\Tenant\Email\Models\Receiver;
use Session;



class CustomerController extends BaseController {


    protected $request;
    protected $customer;
    protected $email;

    public function __construct(Customer $customer, Request $request, Bill $bill,Email $email,Receiver $receiver)
    {
        \FB::can('Customer');

        parent::__construct();
        $this->customer = $customer;
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

        return view('tenant.customer.customer')->withPageTitle('Customer')->with($data);

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
                'email'         => 'required|unique:fb_customers',
                'dob'           => '',
                'street_name'   => 'required',
                'street_number' => 'required',
                'telephone'     => 'numeric',
                'mobile'        => 'numeric',


                //'postcode'      => 'required',
                'town'          => 'alpha|between:2,50',

            )
        );

        if ($validator->fails())
            return \Response::json(array('status' => 'fail', 'errors' => $validator->getMessageBag()->toArray()));


       
        $result = $this->customer->createCustomer($this->request, $this->current_user->id);
        $redirect_url = tenant_route('tenant.customer.index');

        return \Response::json(array('success' => true, 'data' => $result['data'], 'template' => $result['template'], 'redirect_url' => $redirect_url));


    }

    function edit()
    {
        $id = $this->request->route('id');
        $customer = $this->customer->find($id);
        if ($customer == null) {
            show_404();
        }

        return view('tenant.customer.editCustomer', compact('customer'));
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
        $customer1 = $this->customer->find($id);

        if (empty($customer1))
            return $this->fail(['error' => 'Invalid Customer ID']);


        if ($this->request['type'] == 2)
            $dob = '';
        elseif ($this->request['type'] == 1)
            $dob = $this->request['year'] . '-' . $this->request['month'] . '-' . $this->request['day'];

        $validator = \Validator::make($this->request->all(),
            array(
                'name'          => 'required|between:2,30',
                'email'         => 'required',
                'dob'           => '',
                'street_name'   => 'required',
                'street_number' => 'required',

                'telephone'     => 'numeric',
                'mobile'        => 'numeric',

                //'postcode'      => 'required',
                'town'          => 'between:2,50',
                
            )
        );

        if ($validator->fails())
            return \Response::json(array('status' => 'fail', 'errors' => $validator->getMessageBag()->toArray()));

       
        $customers = $this->customer->updateCustomer($id, $this->request, $dob, $this->current_user->id);

        $redirect_url = tenant_route('tenant.customer.index');

        return \Response::json(array('success' => true, 'data' => $customers['data'], 'template' => $customers['template'], 'show_url' => $customers['show_url'], 'edit_url' => $customers['edit_url'], 'redirect_url' => $redirect_url));
    }

    function invoices(){
        if ($this->request->ajax()) {
            $select = ['id', 'total', 'due_date', 'status'];
            $customer_id = Session::get('customer_id');
            $json = $this->bill->dataTablePaginationCustomer($this->request, $select,$customer_id);
           Session::forget('customer_id');
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

            $json = $this->customer->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }

    public function customerCard()
    {
        $user_id = $this->request->route('id');

        $customer = $this->customer->where('id', '=', $user_id)->first();
      Session::put('customer_id', $user_id);
       
        $invoices = $this->bill->getCustomerBill($user_id);

     
       //$mails = $this->receiver->customer($user_id)->with('attachments', 'receivers');
        $mails = $this->email->getCustomerEmail($user_id);
       //dd($mails);
     


        return view('tenant.customer.customerCard', compact('customer','invoices','mails'))->withPageTitle('Customer');
    }

    public function deleteCustomer()
    {
        $id = $this->request->route('id');
        $customer = $this->customer->find($id);
        if (!empty($customer)) {
            if ($customer->delete()) {
                return $this->success(['message' => 'Customer deleted Successfully']);
            }
        }

        return $this->fail(['message' => 'Something went wrong. Please try again later']);

    }



    public function changeStatus()
    {
        $customer_id = Input::get('cus_id');
        $status = Input::get('status');

        $customer = $this->customer->find($customer_id);
        if (!empty($customer)) {
            $customer->status = $status;
            $customer->save();

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

    public function getCustomerSuggestions()
    {
        $name = \Input::get('name');
        //change this later
        $details = Customer::where('name', 'LIKE', '%' . $name . '%')->get();
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

    public function getCustomerDetails()
    {
        $customer_id = $this->request->route('customerId');
        $customer = Customer::find($customer_id);
        $customer->paymentNo = $this->bill->getCustomerPayment($customer_id);
        $customer->invoiceNo = $this->bill->getPrecedingInvoiceNumber($customer_id);

        return \Response::json(['success' => true, 'details' => $customer]);
    }


}
