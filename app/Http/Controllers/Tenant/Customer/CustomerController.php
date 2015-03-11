<?php
namespace App\Http\Controllers\Tenant\Customer;

use App\Models\Tenant\Customer;
use App\Http\Controllers\Tenant\BaseController;
use Illuminate\Http\Request;
use Input;

class CustomerController extends BaseController {


    protected $request;
    protected $customer;

    public function __construct(Customer $customer, Request $request)
    {
        \FB::can('Customer');

        parent::__construct();
        $this->customer = $customer;
        $this->request = $request;
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
    public function create(Request $request)
    {
         $fileName = '';
        
        if ($this->request->hasFile('photo')) {
            $file = $this->request->file('photo');
            $fileName = \FB::uploadFile($file);
           
        }


        $validator = \Validator::make($request->all(),
            array(
                'name'          => 'required|between:2,30',
                'email'          => 'required|unique:fb_customers',
                'dob'           => '',
                'street_name'   => 'required',
                'street_number' => 'required',
                'telephone'     => 'between:10,15',
                'mobile'        => 'between:10,15',
                'postcode'      => 'required|size:5',
                'town'          => 'between:2,50',
              //  'photo'         => 'image'
            )
        );

        if ($validator->fails())
            return \Response::json(array('status' => 'fail', 'errors' => $validator->getMessageBag()->toArray()));

       $result = $this->customer->createCustomer($request,$this->current_user->id,$fileName);
        $redirect_url = tenant_route('tenant.customer.index');
        return \Response::json(array('success' => true, 'data' => $result['data'], 'template'=>$result['template'], 'redirect_url' => $redirect_url ));


    }

    function edit($id)
    {
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
        if($file)
            return \Response::json(array('status' => 'success', 'file'=> $file));
    }

    function update($id)
    {
       
        $customer = $this->customer->find($id);

        if (empty($customer))
            return $this->fail(['error' => 'Invalid Customer ID']);

         $fileName = ' ';
        
        if ($this->request->hasFile('photo')) {
            $file = $this->request->file('photo');
            $fileName = \FB::uploadFile($file);
           
        }


        if ($this->request['type'] == 2)
            $dob = '';
        elseif ($this->request['type'] == 1)
            $dob = $this->request['year'] . '-' . $this->request['month'] . '-' . $this->request['day'];

        $validator = \Validator::make($this->request->all(),
            array(
                'name'          => 'required|between:2,30',
                   'email'          => 'required',
                'dob'           => '',
                'street_name'   => 'required',
                'street_number' => 'required',
                'telephone'     => 'between:10,15',
                'mobile'        => 'between:10,15',
                'postcode'      => 'required|size:5',
                'town'          => 'between:2,50',
                //'photo'         => 'image'
            )
        );

        if ($validator->fails())
            return \Response::json(array('status' => 'fail', 'errors' => $validator->getMessageBag()->toArray()));

        $customer = $this->customer->updateCustomer($this->request ,$dob,$this->current_user->id,$fileName);
        $redirect_url = tenant_route('tenant.customer.index');
        return \Response::json(array('success' => true, 'data' => $customer['data'], 'template'=>$customer['template'], 'redirect_url' => $redirect_url ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
  
    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'name','email','created_at'];

            $json = $this->customer->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }

    public function customerCard($user_id)
    {

        $customer = $this->customer->where('id', '=', $user_id)->first();

        return view('tenant.customer.customerCard', compact('customer'))->withPageTitle('Customer');
    }

    public function deleteCustomer($id = '')
    {
        $customer = $this->customer->find($id);
        if (!empty($customer)) {
            if ($customer->delete()) {
                return $this->success(['message' => 'Customer deleted Successfully']);
            }
        }

        return $this->fail(['message' => 'Something went wrong. Please try again later']);

    }


    public function upload() {
        
        $file = Input::file('file');
        
        $input = array('image' => $file);
      
        $rules = array(
            'image' => 'image'
        );
        $validator = \Validator::make($input, $rules);
        if ( $validator->fails() )
        {
            return \Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);

        }
        else {
            $destinationPath = 'uploads/';
            $filename = $file->getClientOriginalName();
            \Input::file('image')->move($destinationPath, $filename);
            return \Response::json(['success' => true, 'file' => asset($destinationPath.$filename)]);
        }

    }
}
