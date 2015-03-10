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
        //dd(\Input::file('photo'));
        $validator = \Validator::make($request->all(),
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
                'photo'         => 'image'
            )
        );

        if ($validator->fails())
            return \Response::json(array('status' => 'fail', 'errors' => $validator->getMessageBag()->toArray()));


        $this->saveCustomer($request->except('_token'));

        $redirect_url = \URL::route('tenant.customer.index');

        return \Response::json(array('status' => 'success', 'redirect_url' => $redirect_url));


    }

    function edit($id)
    {
        $customer = $this->customer->find($id);
        if ($customer == null) {
            show_404();
        }

        return view('tenant.customer.editCustomer', compact('customer'));
    }

    function update($id)
    {
        //dd(\Input::file('photo'));
        $customer = $this->customer->find($id);

        if (empty($customer))
            return $this->fail(['error' => 'Invalid Customer ID']);

        $fileName = '';
        if ($this->request->hasFile('photo')) {
            $file = $this->request->file('photo');
            $fileName = \FB::uploadFile($file);
            //dd('jsdh'.$fileName);
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
                'photo'         => 'image'
            )
        );

        if ($validator->fails())
            return \Response::json(array('status' => 'fail', 'errors' => $validator->getMessageBag()->toArray()));

        $customer->type = $this->request->input('type');
        $customer->name = $this->request->input('name');
        $customer->email = $this->request->input('email');
        $customer->user_id = $this->current_user->id;
        $customer->dob = $dob;
        $customer->company_number = $this->request->input('company_number');
        $customer->street_name = $this->request->input('street_name');
        $customer->street_number = $this->request->input('street_number');
        $customer->telephone = $this->request->input('telephone');
        $customer->mobile = $this->request->input('mobile');
        $customer->postcode = $this->request->input('postcode');
        $customer->town = $this->request->input('town');
        $customer->image = $fileName;
        $customer->status = $this->request->input('status');
        $customer->save();

        return $this->success(['data' => $customer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function saveCustomer($request)
    {

        $fileName = '';
        // if (\FacadeRequest::hasFile('photo')) {
        //     $file = \FacadeRequest::file('photo');
        //     $fileName = \FB::uploadFile($file);
        // }
        $this->customer->createCustomer($request);
    }

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
        dd($input);
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
