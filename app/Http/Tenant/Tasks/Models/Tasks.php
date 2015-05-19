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
    protected $fillable = ['subject', 'body', 'due_date', 'files', 'is_complete', 'completion_date', 'user_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    function add(Request $request)
    {
        $files = $request->input('file');
        $time = date("H:i:s", strtotime($request->input('due_time')));
        $data = [
            'subject' => $request->input('subject'),
            'body' => $request->input('body'),
            'due_date' => $request->input('due_date').' '.$time,
            'files' => (is_array($files)) ? serialize($files) : null,
            'is_complete' => 0,
            'user_id' => current_user()->id,
        ];
        $task = Tasks::create($data);
        $task = $task->toArray();
        $task['template'] = $this->getTemplate($task);
        return $task;
    }


    function edit(Request $request, $id)
    {
        $files = $request->input('file');
        $time = date("H:i:s", strtotime($request->input('due_time')));
        $task = Tasks::find($id);
        $task->subject = $request->input('subject');
        $task->body = $request->input('body');
        $task->files = (is_array($files)) ? serialize($files) : null;
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

        $display_date = ($task['is_complete'] == 1)? $task['completion_date'] : $task['due_date'];

        $template = '<input type="checkbox" value="" name="" class="icheck"'.$complete.' />
                      <span class="text">'.$task['subject'].'</span>
                      '.calculate_todo_time($display_date).'
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
                        <p>'.nl2br($task['body']).'</p>
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
        $tasks['completed_tasks'] = Tasks::where('is_complete', 1)->where('user_id', current_user()->id)->orderBy('completion_date', 'desc')->paginate($per_page);
        $tasks['todo_tasks'] = Tasks::where('is_complete', 0)->where('user_id', current_user()->id)->where('due_date', '>=', $today)->where('due_date', '<', $tomorrow)->orderBy('due_date', 'asc')->paginate($per_page);
        return $tasks;
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
