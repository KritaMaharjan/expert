<?php
namespace App\Http\Controllers\System;

use App\Models\System\Application\Application;
use App\Models\System\Lender\ApplicationLender;
use App\Models\System\Lender\Lender;
use Illuminate\Http\Request;

class LenderController extends BaseController
{
    protected $lender;
    protected $request;

    protected $rules = [
        'company_name' => 'required|min:2|max:55',
        'contact_name' => 'required|min:2|max:55'
    ];

    protected $assign_rules = [
        'lender_id' => 'required|exists:lenders,id',
        'description' => 'required'
    ];

    public function __construct(Lender $lender, Application $application, Request $request)
    {
        parent::__construct();
        $this->lender = $lender;
        $this->application = $application;
        $this->request = $request;
    }

    function index()
    {
        return view('system.lender.index');
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'company_name', 'contact_name', 'created_at'];

            $json = $this->lender->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }

    function add()
    {
        return view('system.lender.create');
    }

    function profile()
    {
        $data['lender'] = Lender::where('id', $this->current_lender()->id)->with('lender_addresses.address', 'lender_phones.phone')->first();
        //dd($data['lender']->toArray());
        return view('system.lender.profile', $data);
    }

    function create()
    {
        $validator = \Validator::make($this->request->all(), $this->rules);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();
        $this->lender->add($this->request->all());
        \Flash::success('Lender added successfully!');
        return redirect()->route('system.lender');
    }

    function edit()
    {
        $lender_id= $this->request->route('id');
        $data['lender'] = Lender::find($lender_id);
        return view('system.lender.edit', $data);
    }

    function update()
    {
        $lender_id= $this->request->route('id');

        $validator = \Validator::make($this->request->all(), $this->rules);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->lender->edit($this->request->all(), $lender_id);

        \Flash::success('Lender updated successfully!');
        return redirect()->route('system.lender');
    }

    function delete()
    {
        $lender_id = $this->request->route('id');
        ApplicationLender::where('lender_id', $lender_id)->delete();
        Lender::find($lender_id)->delete();
        return $this->success(['message' => 'Lender deleted Successfully']);
    }

    function assign()
    {
        $application_id= $this->request->route('id');
        $data['application'] = $this->application->getApplicationDetails($application_id);
        $lender = Lender::select('id', 'company_name', 'contact_name')->get();
        $data['lender'][''] = 'Choose Lender';
        if(!empty($lender)) {
            $lender = $lender->toArray();
            foreach ($lender as $lender_person) {
                $data['lender'][$lender_person['id']] = $lender_person['company_name'] . ', ' . $lender_person['contact_name'];
            }
        }
        return view('system.lender.assign', $data);
    }

    function postAssign()
    {
        $validator = \Validator::make($this->request->all(), $this->assign_rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $application_id= $this->request->route('id');
        $this->lender->assign($this->request->all(), $application_id);

        \Flash::success('Application lender successfully!');
        return redirect()->route('system.application.accepted');
    }

}