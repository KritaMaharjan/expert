<?php

namespace App\Http\Tenant\Invoice\Controllers;

use App\Fastbooks\Libraries\Pdf;
use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Collection\Models\Collection;
use App\Http\Tenant\Invoice\Models\Bill;
use App\Http\Tenant\Invoice\Models\BillProducts;
use App\Models\Tenant\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use App\Models\Tenant\Setting;
use App\Http\Tenant\Invoice\Models\BillPayment;

class BillController extends BaseController {


    protected $bill;
    protected $request;

    public function __construct(Bill $bill, Request $request, Setting $setting, Collection $collection)
    {
        \FB::can('Invoice');
        parent::__construct();
        $this->bill = $bill;
        $this->request = $request;
        $this->setting = $setting;
        $this->collection = $collection;
    }

    protected $rules = [
        'customer' => 'required',
        'due_date' => 'required|date'
    ];


    /**
     * show product manage page
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('tenant.invoice.bill.index')->with('pageTitle', 'All Bills');
    }

    public function dataJson()
    {
        if ($this->request->ajax()) {
            $select = ['b.id', 'b.invoice_number', 'b.customer_id', 'b.total', 'b.due_date', 'b.created_at', 'b.status', 'b.payment'];
            $json = $this->bill->dataTablePagination($this->request, $select);
            echo json_encode($json, JSON_PRETTY_PRINT);
        } else {
            show_404();
        }
    }


    public function add()
    {
        $months = \Config::get('tenant.month');
         $c_id = $this->request->input('id');
        if(!empty($c_id)){
               $customer_id = $c_id;
               $customer_details =  \DB::table('fb_customers')->where('id', $c_id)->first();
        }
         
        else
            $customer_id ='';
         
        $currencies = \Config::get('tenant.currencies');
        $vat = \Config::get('tenant.vat');
        $data = array('months' => $months, 'currencies' => \Config::get('tenant.currencies'));
        $company_details = $this->getCompanyDetails();

        return view('tenant.invoice.bill.create', compact('company_details','months','currencies','customer_details','customer_id', 'vat'))->with('pageTitle', 'Add new bill')->with($data);
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
            return redirect()->back()->withErrors($validator)->withInput();

        $this->bill->add($this->request, $this->current_user()->id);

        Flash::success('Bill added successfully!');
        return tenant()->route('tenant.invoice.bill.index');
    }

    function view()
    {
        $id = $this->request->route('id');
        $bill = $this->bill->with('payments')->find($id);
        if ($bill == null) {
            show_404();
        }
        return view('tenant.invoice.bill.view', compact('bill'));
    }


    /**
     * display edit form
     * @return string
     */
    function edit()
    {
        $id = $this->request->route('id');

        $bill = $this->bill->billDetails($id);
        if ($bill == null || empty($bill)) {
            show_404();
        }
        $company_details = $this->getCompanyDetails();
        $months = \Config::get('tenant.month');
        $data = array('months' => $months, 'currencies' => \Config::get('tenant.currencies'));

        return view('tenant.invoice.bill.edit', compact('bill'))->with('pageTitle', 'Update Bill')->with('company_details', $company_details)->with($data);
    }

    /**  update bill detail
     * @return string
     */
    function update()
    {
        $id = $this->request->route('id');

        $bill = $this->bill->find($id);
        if (empty($bill))
            show_404();

        $validator = Validator::make($this->request->all(), $this->rules);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->bill->edit($this->request, $id);

        Flash::success('Bill updated successfully!');

        return tenant()->route('tenant.invoice.bill.index');
    }

    function delete()
    {
        $id = $this->request->route('id');

        $bill = Bill::find($id);
        if (!empty($bill)) {
            if ($bill->delete()) {
                $product_bills = BillProducts::where('bill_id', $id)->get();
                if (!empty($product_bills)) {
                    foreach ($product_bills as $product_bill) {
                        $product_bill->delete();
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
        $pdf->generate($data['invoice_number'], 'template.bill', compact('data'), true);
    }

    function sendEmail(Pdf $pdf)
    {
        if ($this->request->ajax())
        {
            $id = $this->request->route('id');
            $data = $this->getInfo($id);
            $pdf_file[] = $pdf->generate(time(), 'template.bill', compact('data'), false, true);
            $mail = \FB::sendEmail($data['customer_details']['email'], $data['customer'], 'bill_email', ['{{NAME}}' => $data['customer']], $pdf_file);
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

    function payment(BillPayment $payment)
    {
        if($this->request->ajax()) {
            $id = $this->request->route('id');
            //$bill_remaining = Bill::find($id, ['remaining'])->remaining;
            $bill = Bill::find($id);

            $bill_remaining = $bill->remaining;

            if($bill->status == Bill::STATUS_COLLECTION) {
                $step = $this->request->input('step');
                $bill_remaining += $this->collection->totalCharge($bill->due_date, $bill->total, $step);
            }

            $payment_rules = [
                'payment_date' => 'required|date',
                'paid_amount' => 'required|numeric|maxValue:'.$bill_remaining
            ];

            $validator = Validator::make($this->request->all(), $payment_rules);
            if ($validator->fails())
                return $this->fail(['errors' => $validator->getMessageBag()]);

            $pay_details = $payment->add($this->request, $id);
            return ($pay_details) ? $this->success($pay_details) : $this->fail(['errors' => 'Something went wrong!']);
        }
    }

    function getInfo($id)
    {
        $bill = $this->bill->billDetails($id);
        $company_details = $this->getCompanyDetails();
        $bill_details = array(
            'id' => $bill->id,
            'amount' => $bill->total,
            'currency' => $bill->currency,
            'invoice_number' => $bill->invoice_number,
            'invoice_date' => $bill->created_at,
            'due_date' => $bill->due_date,
            'customer' => $bill->customer,
            'customer_payment_number' => $bill->customer_payment_number,
            'customer_details' => $bill->customer_details->toArray(),
            'company_details' => $company_details
        );

        return $bill_details;
    }

    function credit()
    {
        if($this->request->ajax()) {
            $id = $this->request->route('id');
            $bill = $this->bill->creditBill($id);
            return ($bill) ? $this->success(['result' => $bill]) : $this->fail(['errors' => 'Something went wrong!']);
        }
    }

}
