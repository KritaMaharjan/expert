<?php namespace App\Http\Tenant\Tasks\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject', 'body', 'due_date', 'is_complete', 'completion_date'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    function add(Request $request)
    {
        $task = Tasks::create([
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
            'due_date' => $request->input('due_date')
        ]);
        return $task->id;
    }


    function edit(Request $request, $id)
    {
        $task = Tasks::find($id);
        $task->subject = $request->input('subject');
        $task->body = $request->input('body');
        $task->due_date = $request->input('due_date');
        $task->save();
    }

    function markComplete($id)
    {
        $task = Tasks::find($id);
        $task->is_complete = 1;
        $task->completed_date = Carbon::now();
        $task->save();
    }

    function dataTablePagination(Request $request, array $select = array())
    {
        if ((is_array($select) AND count($select) < 1)) {
            $select = "*";
        }

        $take = ($request->input('length') > 0) ? $request->input('length') : 15;
        $start = ($request->input('start') > 0) ? $request->input('start') : 0;

        $search = $request->input('search');
        $search = $search['value'];
        $order = $request->input('order');
        $column_id = $order[0]['column'];
        $columns = $request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $tasks = array();
        $query = $this->select($select);

        if ($orderColumn != '' AND $orderdir != '') {
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        if ($search != '') {
            $query = $query->where('subject', 'LIKE', "%$search%");
        }
        $tasks['total'] = $query->count();


        $query->skip($start)->take($take);

        $data = $query->get();

        foreach ($data as $key => &$value) {
            $value->raw_status = $value->status;
            if ($value->is_complete == 1)
                $value->is_complete = '<span class="label label-success">Complete</span>';
            else
                $value->is_complete = '<span class="label label-danger">Incomplete</span>';

            $value->due_date = date('d-M-Y  h:i:s A', strtotime($value->due_date));
            //$value->created_at->format('d-M-Y  h:i:s A');
            $value->DT_RowId = "row-" . $value->id;
        }

        $tasks['data'] = $data->toArray();

        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $tasks['total'];
        $json->recordsFiltered = $tasks['total'];
        $json->data = $tasks['data'];

        return $json;
    }


    function billDetails($id = '')
    {
        $bill = Bill::find($id);

        if ($bill != null) {
            $customer = Customer::find($bill->customer_id);
            $bill->customer = $customer->name;
            $bill->customer_details = $customer;

            $bill_products = BillProducts::where('bill_id', $id)->get();
            if ($bill_products) {
                foreach ($bill_products as $bill_product) {
                    $bill_product->product_name = Product::find($bill_product->product_id)->name;
                }
                $bill->products = $bill_products;
            }

            return $bill;
        }

        return false;
    }

    function getPrecedingInvoiceNumber($customer_id)
    {
        $today = \Carbon::now()->format('Y-m-d');
        $latest_count = Bill::select('id')->where('customer_id', $customer_id)->where('created_at', '>', $today)->count();
        //$latest = Bill::select('id')->where('customer_id',$customer_id)->orderBy('id', 'desc')->first();
        if ($latest_count)
            $new_invoice_num = date('dmy') . format_id($customer_id) . '-' . ($latest_count + 1);
        else
            $new_invoice_num = date('dmy') . format_id($customer_id) . '-1';

        return $new_invoice_num;
    }

    function getCustomerPayment($id = null)
    {
        $latest = Bill::select('id')->orderBy('id', 'desc')->first();
        if ($latest)
            $new_cus_no = format_id($id, 3) . sprintf("%03d", ($latest->id + 1));
        else
            $new_cus_no = format_id($id, 3) . '001';

        return $new_cus_no;
    }

    function convertToBill($id)
    {
        $bill = Bill::find($id);
        if ($bill) {
            $bill->is_offer = 0;
            $bill->save();

            return $bill;
        } else
            return false;
    }
}
