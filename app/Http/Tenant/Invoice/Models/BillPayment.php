<?php
namespace App\Http\Tenant\Invoice\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

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
            $bill->status = 2;
            $bill->save();

            \DB::commit();
            return array('payment_details' => $payment);

        } catch (\Exception $e) {
            \DB::rollback();
            throw $e;
        }
    }

} 