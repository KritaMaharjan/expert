<?php
namespace App\Http\Tenant\Invoice\Models;

use App\Http\Tenant\Accounting\Libraries\Record;
use App\Models\Tenant\Customer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Tenant\Invoice\Models\Bill;

class BillPayment extends Model
{

    protected $table = 'fb_bill_payment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['bill_id', 'amount_paid', 'payment_date'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    function add(Request $request, $bill_id)
    {
        // Start transaction!
        \DB::beginTransaction();
        try {
            $payment = BillPayment::create([
                'bill_id' => $bill_id,
                'amount_paid' => $request->input('paid_amount'),
                'payment_date' => $request->input('payment_date')
            ]);

            $bill = Bill::find($bill_id);
            $bill->paid = $bill->paid + $request->input('paid_amount'); //do it for remaining too
            $bill->remaining = $bill->remaining - $request->input('paid_amount'); //do it for remaining too

            if ($bill->remaining > 0)
                $bill->payment = 2;
            else {
                $bill->payment = 1;
                $bill->full_payment_date = $request->input('payment_date');
            }
            $bill->save();

            \DB::commit();

            $customer = Customer::find($bill->customer_id);
            Record::billPayment($bill, $customer, $payment->amount_paid);

            $template = $this->getBillTemplate($bill);
            return array('bill_details' => $template, 'id' => $bill->id);
            //return array('payment_details' => $payment);

        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }
        return false;
    }

    function getBillTemplate(Bill $bill)
    {
        $bill_model = new Bill();
        $status = $bill_model->getStatus($bill->status, $bill->payment);
        $template = '
            <td class="sorting_1"><a href="#" class="link">'.$bill->invoice_number.'</a></td>
            <td>'.$bill->customer->name.'</td>
            <td>'.number_format($bill->total, 2).'</td>
            <td>'.number_format($bill->remaining, 2).'</td>
            <td>'.date('d-M-Y  h:i:s A', strtotime($bill->created_at)).'</td>
            <td>'.$status.'</td>
            <td>
            <div class="box-tools"><a data-target="#fb-modal" data-url="'.tenant()->url("invoice/bill/".$bill->id).'"
                                      data-toggle="modal" class="btn btn-box-tool" data-original-title="View"
                                      title="View Payments" href="#"><i class="fa fa-eye"></i></a>
                <button data-original-title="Remove" data-id="'.$bill->id.'" data-toggle="tooltip"
                        class="btn btn-box-tool btn-delete-bill"><i class="fa fa-times"></i></button>
            </div>
            </td>';
        return $template;
    }

}
