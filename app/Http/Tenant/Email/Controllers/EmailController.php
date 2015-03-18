<?php

namespace APP\Http\Tenant\Email\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Tenant\Email\Models\Email;

class EmailController extends BaseController {

    protected $request;
     protected $email;


    function __construct(Request $request,Email $email)
    {
        parent::__construct();
        $this->request = $request;
        $this->email = $email;
    }

     protected $rules = [
        'subject'    => 'required',
        'email_to'      => 'required',
        'message' => 'required'
    ];

    function index()
    {
       // $mails = $this->email->where('user_id', '=', $this->current_user->id)->get();
        $data = array('mails' => '');

        return view('tenant.email.index')->withPageTitle('Emails')->with($data);
        
    }

    function getCustomer()
    {
        $email_to = \Input::get('email_to');
        $details = \DB::table('fb_customers')->where('email', 'LIKE', '%'.$email_to.'%')->get();
        return \Response::json($details);
    }


    // function attach()
    // {
    //     if ($this->request->hasFile('file') AND $this->request->file('file')->isValid()) {
    //         $extension = $this->request->file('file')->getClientOriginalExtension();
    //         $destinationPath = './assets/uploads/';
    //         $fileName = uniqid() . '_' . time() . '.' . $extension;
    //         $data = $this->request->file('file')->move($destinationPath, $fileName);
    //         $return = ['pathName' => asset(trim($data->getPathname(), '.')), 'fileName' => $data->getFilename()];

    //         return $this->success($return);
    //     } else {
    //         return $this->fail(['error' => 'File upload failed']);
    //     }

    //     return $this->fail(['error' => 'Invalid access']);
    // }


    // function send()
    // {
    //     $validator = $this->validateComposer();
    //     if ($validator->fails()) {
    //         return $this->fail(['errors' => $validator->messages()]);
    //     }

    //     return $this->success($this->request->all());
    // }


    function send(){
         $validator = Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return $this->fail(['errors' => $validator->messages()]);

        $result = $this->email->add($this->request);

    }

    // function validate($rules)
    // {
    //     $rules = [];
    //     $validator = Validator::make($this->request->all(), $rules);

    //     return $validator;
    // }


}