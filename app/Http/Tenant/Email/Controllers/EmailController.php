<?php

namespace APP\Http\Tenant\Email\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Models\Tenant\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Tenant\Email\Models\Email;

class EmailController extends BaseController {

    protected $request;
    protected $email;


    function __construct(Request $request, Email $email)
    {
        parent::__construct();
        $this->request = $request;
        $this->email = $email;
    }

    function index()
    {
        $mails = $this->email->user()->with('attachments', 'receivers')->paginate(10);
        return view('tenant.email.index', compact('mails'));
    }

    function customerSearch(Customer $customer)
    {
        $query = $this->request->input('term');
        $details = $customer->select('id', 'name as label', 'email as value')->where('email', 'LIKE', '%' . $query . '%')->orWhere('name', 'LIKE', '%' . $query . '%')->get()->toArray();

        return \Response::JSON($details);
    }

    function attach()
    {
        if ($this->request->hasFile('file') AND $this->request->file('file')->isValid()) {
            $extension = $this->request->file('file')->getClientOriginalExtension();
            $destinationPath = './assets/uploads/';
            $fileName = uniqid() . '_' . time() . '.' . $extension;
            $data = $this->request->file('file')->move($destinationPath, $fileName);
            $return = ['pathName' => asset(trim($data->getPathname(), '.')), 'fileName' => $data->getFilename()];

            return $this->success($return);
        } else {
            return $this->fail(['error' => 'File upload failed']);
        }

        return $this->fail(['error' => 'Invalid access']);
    }



    function send()
    {
        $validator = $this->validateComposer();
        if ($validator->fails()) {
            return $this->fail(['errors' => $validator->messages()]);
        }

        if ($email = $this->email->send()) {
            return $this->success($email);
        }

        return $this->fail(['error' => 'Could not send email at this moment. Please try again later']);

    }


    function validateComposer()
    {
        $rules = [
            'email_to' => 'required|validArrayEmail',
            'email_cc' => 'validArrayEmail',
            'subject'  => 'required',
            'message'  => 'required'
        ];
        $validator = \Validator::make($this->request->all(), $rules);

        return $validator;
    }


}