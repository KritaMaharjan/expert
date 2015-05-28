<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">Bill Details</h3>
    </div>
    <div class="box-body">
        <div class="box-body table-responsive">
            <table class="table">
                <thead>
                    <th colspan="2">Bill Details</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Invoice Number</td>
                        <td>{{ $bill->invoice_number }}</td>
                    </tr>
                    <tr>
                        <td>Customer</td>
                        <td>{{ $bill->customer_id }}</td>
                    </tr>
                    <tr>
                        <td>Currency</td>
                        <td>{{ $bill->currency }}</td>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <td>{{ float_format($bill->subtotal) }}</td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td>{{ float_format($bill->tax) }}</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>{{ float_format($bill->total) }}</td>
                    </tr>
                    <tr>
                        <td>Total Paid</td>
                        <td>{{ float_format($bill->paid) }}</td>
                    </tr>
                    <tr>
                        <td>Total Remaining</td>
                        <td>{{ float_format($bill->remaining) }}</td>
                    </tr>
                    <tr>
                        <td>Due Date</td>
                        <td>{{ format_only_date($bill->due_date) }}</td>
                    </tr>
                    <tr>
                        <td>Issued on</td>
                        <td>{{ format_datetime($bill->created_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <legend>Payment Details</legend>
        @if(count($bill->payments) < 1)
            No payment records
        @else
            <table class="table">
                <thead>
                    <th>Amount Paid</th>
                    <th>Payment Date</th>
                </thead>
                <tbody>
                @foreach($bill->payments as $payment)
                    <tr>
                        <td>{{$payment->amount_paid}}</td>
                        <td>{{ format_only_date($payment->payment_date) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="box-footer">
        <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
    </div>
</div>
