<?php
namespace APP\Http\Tenant\Collection\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Collection\Models\Collection;
use App\Http\Tenant\Collection\Models\CourtCase;
use App\Http\Tenant\Collection\Repositories\CollectionRepository;
use App\Http\Tenant\Invoice\Models\Bill;
use Illuminate\Http\Request;

class CollectionController extends BaseController {

    /**
     * @var CollectionRepository
     */
    private $repo;
    /**
     * @var Request
     */
    private $request;

    public function __construct(CollectionRepository $repo, Request $request)
    {
        parent::__construct();
        $this->repo = $repo;
        $this->request = $request;
    }

    public function index()
    {
        return view('tenant.collection.index');
    }


    public function waiting()
    {
        return view('tenant.collection.waiting');
    }

    public function addCase()
    {
        return view('tenant.collection.add_case');
    }

    public function makeCollectionCase()
    {
        if ($this->request->ajax()) {
            $id = $this->request->route('id');
            if ($this->repo->makeCase($id)) {
                return $this->success(['message' => 'Bill add to collection case']);
            }

            return $this->fail(['message' => 'Bill couldn\'t converted to collection case']);
        }
    }

    public function data()
    {
        if ($this->request->ajax()) {
            $collectionWaiting = $this->repo->billsOnCollection();
            echo json_encode($collectionWaiting, JSON_PRETTY_PRINT);
        }
    }

    public function waitingData()
    {
        if ($this->request->ajax()) {
            $collectionWaiting = $this->repo->billsWaitingCollection();
            echo json_encode($collectionWaiting, JSON_PRETTY_PRINT);
        }
    }

    function cancel()
    {
        if($this->verifyCsrf()) {
            $id = $this->request->get('bill');
            try {
                $this->repo->cancelBillCollection($id);
                flash()->success('Bill cancel successfully');
            } catch (\Exception $e) {
                flash()->error($e->getMessage());
            }

            return redirect()->back();
        }

        show_404();
    }

    function goToStep()
    {
        if($this->verifyCsrf())
        {
            $step = $this->request->route('step');
            $id = $this->request->get('bill');
            $this->changeStep($id, $step);
            return redirect()->back();
        }

        show_404();
    }

    private function changeStep($id, $step)
    {
        try {
            $this->repo->changeCollectionStep($id, $step);
            if($step == 'court')
                $message = 'Court Case created.';
                else
                $message = 'Collection case updated.';
            flash()->success($message);

        } catch (\Exception $e) {
            flash()->error($e->getMessage());
        }
    }


    private function verifyCsrf()
    {
        $token = $this->request->get('token');
        $csrfToken = $this->request->session()->token();

        return ($token == $csrfToken);
    }


    function generatePdf()
    {
        $step = $this->request->route('step');

        if (Collection::isValidStep($step) AND $this->verifyCsrf()) {
            $id = $this->request->get('bill');
            $this->repo->generatePDF($id, $step);
        } else {
            show_404();
        }

    }

    function disputeBill()
    {
        if($this->verifyCsrf())
        {
            $bill = $this->request->get('bill');
            $pdf = $this->repo->getAllCollectionPDF($bill);
            $emails = $this->repo->getEmailsByInvoice($bill);
            return view('tenant.collection.case', compact('pdf', 'emails', 'bill'));
        }

        show_404();
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    function createCourtCase()
    {
        $bill = $this->request->input('bill');
        $pdf = $this->request->input('pdf', []);
        $emails = $this->request->input('emails', []);
        $information = $this->request->input('information', []);

        if(Bill::find($bill) AND !empty($pdf))
            {
                $case = [
                    'bill_id'=> $bill,
                    'pdf' => json_encode($pdf),
                    'email' => json_encode($emails),
                    'information' =>$information
                ];

                if(CourtCase::create($case))
                {
                    $this->changeStep($bill, 'court');
                    return redirect()->back();
                }
            }
        show_404();
    }

    function registerDate()
    {
        $bill = $this->request->input('bill');
        if($this->verifyCsrf() AND !is_null($bill) AND $bill = Bill::with('customer')->find($bill)) {
            $due_amount = $bill->remaining + Collection::totalCharge($bill->due_date, $bill->total,'court');
            $body = "Invoice Number : {$bill->invoice_number} \nCustomer Name: {$bill->customer->name} \nDue Amount: {$due_amount}";
            return view('tenant.collection.register_date', compact('body'));
        }
    }

    function caseHistory()
    {
        $bill = $this->request->input('bill');

        if($this->verifyCsrf() AND !is_null($bill) AND Bill::find($bill)) {

            $case = $this->repo->caseHistoryDetail($bill);

            return view('tenant.collection.history', compact('case'));
        }
        show_404();
    }
}