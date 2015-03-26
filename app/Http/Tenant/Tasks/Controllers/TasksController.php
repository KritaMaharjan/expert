<?php

namespace App\Http\Tenant\Tasks\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Tasks\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class TasksController extends BaseController {

    protected $task;
    protected $request;

    public function __construct(Tasks $task, Request $request)
    {
        \FB::can('Invoice');
        parent::__construct();
        $this->task = $task;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    protected $rules = [
        'subject' => 'required|between:2,100',
        'body' => 'required',
        'due_date' => 'required|date'
    ];


    /**
     * show product manage page
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tasks = Tasks::all();
        return view('tenant.tasks.index', compact('tasks'))->with('pageTitle', 'All Tasks');
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['id', 'subject', 'due_date', 'is_complete'];
            $json = $this->task->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
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
            return $this->fail(['errors' => $validator->getMessageBag()]);

        $result = $this->task->add($this->request);
        return ($result) ? $this->success(['result' => $result]) : $this->fail(['errors' => 'Something went wrong!']);

    }


    /**
     * Display product detail
     * @return string
     */
    function show()
    {
        $id = $this->request->route('id');
        $task = $this->task->find($id);
        if ($task == null) {
            show_404();
        }

        if ($this->request->ajax()) {
            return $this->success($task->toArray());
        }

        return view('tenant.product.show', compact('product'));

    }


    /**
     * display edit form
     * @return string
     */
    function edit()
    {
        $id = $this->request->route('id');

        $task = $this->task->taskDetails($id);
        if ($task == null || empty($task)) {
            show_404();
        }
        $company_details = $this->getCompanyDetails();
        $months = \Config::get('tenant.month');
        $data = array('months' => $months, 'currencies' => \Config::get('tenant.currencies'));

        return view('tenant.tasks.edit', compact('task'))->with('pageTitle', 'Update Bill')->with('company_details', $company_details)->with($data);
    }

    /**  update task detail
     * @return string
     */
    function update()
    {
        $id = $this->request->route('id');

        $task = $this->task->find($id);
        if (empty($task))
            show_404();

        $validator = Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->task->edit($this->request, $id);

        Flash::success('Bill updated successfully!');

        return tenant()->route('tenant.invoice.tasks.index');
    }


    function delete()
    {
        $id = $this->request->route('id');

        $task = Bill::find($id);
        if (!empty($task)) {
            if ($task->delete()) {
                $product_tasks = BillProducts::where('task_id', $id)->get();
                if (!empty($product_tasks)) {
                    foreach ($product_tasks as $product_task) {
                        $product_task->delete();
                    }

                    return $this->success(['message' => 'Bill deleted Successfully']);
                }
            }
        }

        return $this->fail(['message' => 'Something went wrong. Please try again later']);
    }

    public function getSuggestions()
    {
        $name = \Input::get('name');
        //change this later
        $details = Product::where('name', 'LIKE', '%' . $name . '%')->get();
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

    function download(Pdf $pdf)
    {
        $id = $this->request->route('id');
        $data = $this->getInfo($id);
        $pdf->generate(time(), 'template.task', compact('data'), false);
    }

    function sendEmail(Pdf $pdf)
    {
        if ($this->request->ajax())
        {
            $id = $this->request->route('id');
            $data = $this->getInfo($id);
            $pdf_file[] = $pdf->generate(time(), 'template.task', compact('data'), false, true);
            $mail = \FB::sendEmail($data['customer_details']['email'], $data['customer'], 'task_email', ['{{NAME}}' => $data['customer']], $pdf_file);
            if($mail) {
                return $this->success(['message' => 'Email Sent Successfully!']);
            }
            return $this->fail(['message' => 'Something went wrong. Please try again later']);
        }
    }

    function printBill()
    {
        $id = $this->request->route('id');
        $data = $this->getInfo($id);
        return view('template.print', compact('data'));
    }


    function getInfo($id)
    {
        $task = $this->task->taskDetails($id);
        $company_details = $this->getCompanyDetails();
        $task_details = array(
            'id' => $task->id,
            'amount' => $task->total,
            'currency' => $task->currency,
            'invoice_number' => $task->invoice_number,
            'invoice_date' => $task->created_at,
            'due_date' => $task->due_date,
            'customer' => $task->customer,
            'customer_details' => $task->customer_details->toArray(),
            'company_details' => $company_details
        );

        return $task_details;
    }

}
