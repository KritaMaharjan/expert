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
    protected $fillable = ['subject', 'body', 'due_date', 'is_complete', 'completion_date', 'user_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    function add(Request $request)
    {
        $time = date("H:i:s", strtotime($request->input('due_time')));
        $task = Tasks::create([
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
            'due_date' => $request->input('due_date').' '.$time,
            'is_complete' => 0,
            'user_id' => current_user()->id,
        ]);

        $task = $task->toArray();
        $task['template'] = $this->getTemplate($task);
        return $task;
    }


    function edit(Request $request, $id)
    {
        $time = date("H:i:s", strtotime($request->input('due_time')));
        $task = Tasks::find($id);
        $task->subject = $request->input('subject');
        $task->body = $request->input('body');
        $task->due_date = $request->input('due_date')." ".$time;
        $task->save();
        $task = $task->toArray();
        $task['template'] = $this->getTemplate($task, true);
        return $task;
    }

    /* *
     * Get template to display after add or update
     * */
    function getTemplate(array $task = array(), $update = false)
    {
        $complete = ($task['is_complete'] == 1)? 'checked="checked"' : '';
        $edit = ($task['is_complete'] == 0)? '<a href="#" title="Edit" data-original-title="Edit" class="btn btn-box-tool"  data-toggle="modal" data-url="'.tenant()->url('tasks/' . $task['id'] . '/edit').'" data-target="#fb-modal" data-url="" >
                            <i class="fa fa-edit"></i>
                        </a>' : '';
        $completed_date = ($task['is_complete'] == 1)? '<div>
                          <label>Completed date:</label>
                          <span>'.format_datetime($task['completion_date']).'</span>
                        </div>' : '';
        $template = '<input type="checkbox" value="" name="" class="icheck"'.$complete.' />
                      <span class="text">'.$task['subject'].'</span>
                      '.calculate_todo_time($task['due_date']).'
                      <div class="tools">
                        '.$edit.'
                        <i class="fa fa-trash-o btn-delete-task" data-id="'.$task['id'].'"></i>
                      </div>
                      <div class="todos-box pad-lr-29">
                        <div>
                          <label>Added date:</label>
                          <span>'.format_datetime($task['created_at']).'</span>
                        </div>
                        <div>
                          <label>Due date:</label>
                          <span>'.format_datetime($task['due_date']).'</span>
                        </div>'.$completed_date.'
                        <p>'.$task['body'].'</p>
                      </div>';
        if($update == false)
            return "<li id='".$task['id']."'>".$template."</li>";
        return $template;
    }

    function markComplete($id)
    {
        $task = Tasks::find($id);
        if($task->is_complete == 0) {
            $task->is_complete = 1;
            $task->completion_date = Carbon::now();
        }
        else
            $task->is_complete = 0;

        $task->save();
        $task = $task->toArray();
        $task['template'] = $this->getTemplate($task);
        return $task;
    }

    function getTasks()
    {
        $per_page = 10;
        $today = \Carbon::now()->format('Y-m-d');
        $tomorrow = \Carbon::now()->addDay()->format('Y-m-d');
        $tasks = array();
        /*$tasks['upcoming_tasks'] = Tasks::where('due_date', '>', $today)->get();
        $tasks['overdue_tasks'] = Tasks::where('due_date', '<=', $today)->get();*/
        $tasks['upcoming_tasks'] = Tasks::where('is_complete', 0)->where('user_id', current_user()->id)->orderBy('due_date', 'asc')->paginate($per_page);
        $tasks['completed_tasks'] = Tasks::where('is_complete', 1)->where('user_id', current_user()->id)->orderBy('completion_date', 'asc')->paginate($per_page);
        $tasks['todo_tasks'] = Tasks::where('is_complete', 0)->where('user_id', current_user()->id)->where('due_date', '>=', $today)->where('due_date', '<', $tomorrow)->orderBy('due_date', 'asc')->paginate($per_page);
        return $tasks;
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
