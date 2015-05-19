<?php

namespace App\Http\Tenant\Collection\Repositories;

use App\Fastbooks\Libraries\Pdf;
use App\Http\Tenant\Accounting\Libraries\Record;
use App\Http\Tenant\Collection\Models\Collection;
use App\Http\Tenant\Collection\Models\CourtCase;
use App\Http\Tenant\Email\Models\Email;
use App\Http\Tenant\Inventory\Models\Product;
use App\Http\Tenant\Invoice\Models\Bill;
use App\Http\Tenant\Invoice\Models\BillProducts;
use App\Models\Tenant\Customer;
use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionRepository {

    /**
     * @var Bill
     */
    private $bill;
    /**
     * @var Collection
     */
    private $collection;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Setting
     */
    private $setting;

    function __construct(Request $request, Bill $bill, Collection $collection, Setting $setting)
    {
        $this->bill = $bill;
        $this->collection = $collection;
        $this->request = $request;
        $this->setting = $setting;
    }

    /**
     * @return \stdClass
     */
    function billsWaitingCollection()
    {
        $status = [BILL::STATUS_UNPAID, BILL::STATUS_PARTIAL_PAID];
        $select = ['b.id', 'c.name as customer_name', 'b.invoice_number', 'b.total', 'b.paid', 'b.remaining', DB::raw('DATE_FORMAT(b.due_date,"%Y-%m-%d") as due_date')];

        $take = ($this->request->input('length') > 0) ? $this->request->input('length') : 15;
        $start = ($this->request->input('start') > 0) ? $this->request->input('start') : 0;

        $search = $this->request->input('search');
        $search = $search['value'];
        $order = $this->request->input('order');
        $column_id = $order[0]['column'];
        $columns = $this->request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $bill = array();

        $query = $this->bill->select($select)->from('fb_bill as b')
            ->leftJoin('fb_customers as c', 'c.id', '=', 'b.customer_id')
            ->where(DB::raw('DATE_ADD(b.due_date,INTERVAL 14 DAY)'), '<', date('Y-m-d'))// get overdue bill
            ->whereIn('b.status', $status)// get bills having collection status
            ->where('b.payment', '!=', BILL::STATUS_PAID)// get only unpaid bill
            ->where('b.status', '=', BILL::STATUS_ACTIVE)// get only unpaid bill
            ->where('b.is_offer', BILL::TYPE_BILL); // get only bill type

        if ($orderColumn != '' AND $orderdir != '') {
            $orderColumn = ($orderColumn == 'customer_name') ? 'c.name' : 'b.' . $orderColumn;
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        if ($search != '') {
            $query = $query->where('c.name', 'LIKE', "%$search%");
        }
        $bill['total'] = $query->count();


        $query->skip($start)->take($take);


        $bill['data'] = $query->get()->toArray();

        $json = new \stdClass();
        $json->draw = ($this->request->input('draw') > 0) ? $this->request->input('draw') : 1;
        $json->recordsTotal = $bill['total'];
        $json->recordsFiltered = $bill['total'];
        $json->data = $bill['data'];

        return $json;
    }


    /**
     * @internal param array $status
     * @internal param array $select
     * @return \stdClass
     */
    public function billsOnCollection()
    {
        $status = [BILL::STATUS_COLLECTION];
        $select = [DB::raw('MAX(col.step) as step'), DB::raw('MAX(col.created_at) as created_at'), 'b.id', 'c.name as customer_name', 'b.invoice_number', 'b.total as bill_total', 'b.paid', 'b.remaining', DB::raw('DATE_FORMAT(b.due_date,"%Y-%m-%d") as due_date')];

        $take = ($this->request->input('length') > 0) ? $this->request->input('length') : 15;
        $start = ($this->request->input('start') > 0) ? $this->request->input('start') : 0;

        $search = $this->request->input('search');
        $search = $search['value'];
        $order = $this->request->input('order');
        $column_id = $order[0]['column'];
        $columns = $this->request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $bill = array();

        $step = $this->request->get('step');
        $step_string = $step == '' ? 'purring' : $step;
        $step = Collection::getStep($step_string);

        $query = $this->bill->select($select)->from('fb_bill as b')
            ->leftJoin('fb_customers as c', 'c.id', '=', 'b.customer_id')
            ->leftJoin('fb_collection as col', 'col.bill_id', '=', 'b.id')
            ->whereIn('b.status', $status)// get bills having collection status
            ->where('b.payment', '!=', BILL::STATUS_PAID)// get only unpaid bill
            ->where('b.is_offer', BILL::TYPE_BILL)// get only bill type
            ->groupBy('b.id')
            ->having('step', '=', $step);
        if ($orderColumn != '' AND $orderdir != '') {

            switch ($orderColumn) {
                case 'customer_name':
                    $orderColumn = 'c.name';
                    break;

                case 'bill_total':
                    $orderColumn = 'b.total';
                    break;

                default:
                    $orderColumn = 'b.' . $orderColumn;
                    break;
            }

            $query = $query->orderBy($orderColumn, $orderdir);
        }

        if ($search != '') {
            $query = $query->where('c.name', 'LIKE', "%$search%");
        }
        $bill['total'] = count($query->get());


        $query->skip($start)->take($take);

        $bill_data = $query->get()->toArray();
        $nextStep = Collection::nextStep($step_string);
        $fee = Collection::fee($step_string);
        foreach ($bill_data as &$bill_value) {
            $bill_value['isGoToStep'] = Collection::isGoToStep($bill_value['created_at']);
            $bill_value['goToStep'] = $nextStep;
            $bill_value['interest'] = $interest = Collection::interest($bill_value['due_date'], $bill_value['bill_total']);
            $bill_value['fee'] = $fee;
            $bill_value['step'] = $step_string;
            $bill_value['remaining'] += ($fee + $interest);
            $bill_value['deadline'] = Collection::GRACE_PERIOD - Collection::deadline($bill_value['created_at']);
            if($step_string == 'court')
            {
                $date = CourtCase::where('bill_id', $bill_value['id'])->first()->payment_date;
                $bill_value['payment_date'] = is_null($date) ?  '' : $date;
                $bill_value['is_payment_date_exceed'] = is_null($date) ?  '' : $this->isExpired($date);
            }
        }


        $bill['data'] = $bill_data;

        $json = new \stdClass();
        $json->draw = ($this->request->input('draw') > 0) ? $this->request->input('draw') : 1;
        $json->recordsTotal = $bill['total'];
        $json->recordsFiltered = $bill['total'];
        $json->data = $bill['data'];

        return $json;
    }


    function isExpired($date)
    {
        if(strtotime($date) < time())
            return true;
        else
            return false;
    }

    /**
     * @param $id
     * @return bool
     */
    function makeCase($id)
    {
        $bill = $this->bill->find($id);
        if ($bill) {
            $bill->status = BILL::STATUS_COLLECTION;
            $bill->save();
            $this->changeCollectionStep($bill->id, 'purring');

            return true;
        }

        return false;
    }


    /**
     * @param $id
     * @return array
     */
    function getBillInfo($id, $step = 'purring')
    {
        $bill = $this->bill->billDetails($id);
        $company = $this->setting->getCompany();
        $business = $this->setting->getBusiness();
        $fix = $this->setting->getFix();
        $company_details = array_merge($company, $business, $fix);
        $late_charge = $this->collection->totalCharge($bill->due_date, $bill->total, $step); //with interest
        $bill_products = $this->getBillProducts($bill->id);
        $interest = $this->collection->interest($bill->due_date, $bill->total);
        $fee = $this->collection->fee($step);

        $bill_details = array(
            'id'                      => $bill->id,
            'amount'                  => $bill->total,
            'remaining'               => $bill->remaining + $late_charge,
            'paid'                    => $bill->paid,
            'currency'                => $bill->currency,
            'invoice_number'          => $bill->invoice_number,
            'invoice_date'            => $bill->created_at,
            'due_date'                => $bill->due_date,
            'customer'                => $bill->customer,
            'customer_payment_number' => $bill->customer_payment_number,
            'customer_details'        => $bill->customer_details->toArray(),
            'company_details'         => $company_details,
            'late_fee'                => $late_charge,
            'gross'                   => $bill->total + $late_charge,
            'products'                => $bill_products,
            'interest'                => $interest,
            'fee'                     => $fee
        );

        return $bill_details;
    }

    function getBillProducts($bill_id)
    {
        $bill_products = BillProducts::where('bill_id', $bill_id)->get();
        if ($bill_products) {
            foreach ($bill_products as $bill_product) {
                $bill_product->product_name = Product::find($bill_product->product_id)->name;
            }
            $products = $bill_products;
            return $products;
        }
    }

    /**
     * @param $bill
     * @param $step
     * @return static
     * @throws \Exception
     */
    function changeCollectionStep($bill, $step)
    {
        $bill = $this->bill->find($bill);
        if ($bill && $this->isValidStep($bill, $step)) {
            $data = [
                'bill_id' => $bill->id,
                'step'    => Collection::getStep($step)
            ];

            return $this->collection->create($data);
        }

        throw new \Exception('Invalid Bill ID');
    }

    /**
     * @param Bill $bill
     * @param $step
     * @return bool
     * @throws \Exception
     */
    public function isValidStep(Bill $bill, $step)
    {
        $collection = $this->collection->where('bill_id', $bill->id)->where('step', Collection::getStep($step))->first();

        if (!empty($collection))
            throw new \Exception('You can\'t change the case status');
        else
            return true;
    }

    function cancelBillCollection($bill)
    {
        $bill = $this->bill->find($bill);
        if ($bill) {
            $bill->status = Bill::STATUS_LOSS;
            $bill->save();
            $customer = Customer::find($bill->customer_id);
            Record::billAsLoss($bill, $customer, $bill->remaining);

            //   $this->collection->where('bill_id', $bill->id)->delete();

            return $bill;
        }

        throw new \Exception('Invalid Bill ID');
    }


    function getAllCollectionPDF($bill)
    {
        $files = [];
        $num = $this->getCurrentStep($bill);
        $num = $num > 3 ? 3 : $num;
        $steps = ['purring', 'inkassovarsel', 'betalingsappfording'];
        for ($i = 0; $i < $num; $i++) {
            list($key, $value) = $this->generatePDF($bill, $steps[$i], false);
            $files[$key] = $value;
        }

        return $files;
    }

    function getCurrentStep($bill)
    {
        $bill = $this->collection->select('step')->where('bill_id', $bill)->orderBy('step', 'DESC')->first();

        return $bill ? $bill->step : null;
    }

    function generatePDF($bill, $step, $download = true)
    {
        $save = true;
        if ($download) {
            $save = false;
        }
        $data = $this->getBillInfo($bill, $step);
        $pdf = new Pdf();
        $fileName = $data['invoice_number'] . '-' . $step;
        //$filePath = $pdf->generate($fileName, 'template.collection.' . $step, compact('data'), $download, $save);
        $filePath = $pdf->generate($fileName, 'template.collection.' . $step, compact('data'));
        return [$fileName, $filePath];
    }


    function getEmailsByInvoice($bill)
    {
        $bill = $this->bill->find($bill);
        $key = $bill->invoice_number;
        $emails = Email::with('receivers')->select('id','subject', 'created_at')->where('subject', 'LIKE', '%'.$key.'%')->orWhere('message', 'LIKE','%'.$key.'%')->orWhere('note', 'LIKE','%'.$key.'%')->orderBy('created_at', 'DESC')->get();
        return $emails;
    }

    function caseHistoryDetail($bill)
    {
        $case = CourtCase::where('bill_id', $bill)->first()->toArray();

        $case['pdf'] = json_decode($case['pdf']);
        $emails = [];
        if($case['email']!='')
        {
            $emailid = json_decode($case['email']);
            if(count($emailid) > 0)
            {
                $emails = Email::with('receivers')->select('id','subject', 'created_at')->whereIn('id', $emailid)->get();
            }
        }

        $case['email'] = $emails;
        return (object) $case;
    }

    function registerPaymentDate(Bill $bill, $payment_date)
    {
        $case  = CourtCase::where('bill_id', $bill->id)->first();
        $case->payment_date = $payment_date;
        return $case->save();
    }

    function getBillRemainingAmount(Bill $bill)
    {
        $step = $this->getStepByBill($bill->id);
        return  $this->collection->totalCharge($bill->due_date, $bill->total, $step) +  $bill->remaining;
    }

    function getStepByBill($bill_id)
    {
        $status = [BILL::STATUS_COLLECTION];
        $select = [DB::raw('MAX(col.step) as step')];

        $row = $this->bill->select($select)->from('fb_bill as b')
            ->leftJoin('fb_collection as col', 'col.bill_id', '=', 'b.id')
            ->whereIn('b.status', $status)// get bills having collection status
            ->where('b.payment', '!=', BILL::STATUS_PAID)// get only unpaid bill
            ->where('b.is_offer', BILL::TYPE_BILL)// get only bill type
            ->where('b.id', $bill_id)
            ->groupBy('b.id')
            ->first();
        return $row->step;
    }

}