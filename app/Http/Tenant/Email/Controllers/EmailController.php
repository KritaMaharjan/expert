<?php

namespace APP\Http\Tenant\Email\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use Illuminate\Http\Request;

class EmailController extends BaseController {


    function index()
    {
        return view('tenant.email.index');
    }


    function upload(Request $request)
    {
        if ($request->hasFile('file') AND $request->file('file')->isValid()) {
            $extension = $request->file('file')->getClientOriginalExtension();
            $destinationPath = './assets/uploads/';
            $fileName = uniqid() . '_' . time() . '.' . $extension;
            $data = $request->file('file')->move($destinationPath, $fileName);
            $return = ['pathName' => asset(trim($data->getPathname(), '.')), 'fileName' => $data->getFilename()];

            return $this->success($return);
        } else {
            return $this->fail(['error' => 'File upload failed']);
        }

        return $this->fail(['error' => 'Invalid access']);
    }


}