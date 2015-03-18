<?php

namespace APP\Http\Tenant\Email\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use Illuminate\Http\Request;

class EmailController extends BaseController {

    protected $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    function index()
    {
        return view('tenant.email.index');
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

        return $this->success($this->request->all());
    }

    function validate($rules)
    {
        $rules = [];
        $validator = Validator::make($this->request->all(), $rules);

        return $validator;
    }


}