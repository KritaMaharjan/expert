<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">Expense Details</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th colspan="2">Expense Details</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Type</td>
                        <td>{{ ($expense->type == 1)? 'Supplier' : 'Cash' }}</td>
                    </tr>
                    @if($expense->type == 1)
                    <tr>
                        <td>Supplier</td>
                        <td>{{ $expense->supplier_id }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Billing Date</td>
                        <td>{{ readable_date($expense->billing_date) }}</td>
                    </tr>
                    <tr>
                        <td>Payment Due Date</td>
                        <td>{{ readable_date($expense->payment_due_date) }}</td>
                    </tr>
                    <tr>
                        <td>Invoice Number</td>
                        <td>{{ $expense->invoice_number }}</td>
                    </tr>
                    {{--<tr>
                        <td>Total</td>
                        <td>{{ float_format($expense->total) }}</td>
                    </tr>
                    <tr>
                        <td>Total Paid</td>
                        <td>{{ float_format($expense->paid) }}</td>
                    </tr>
                    <tr>
                        <td>Total Remaining</td>
                        <td>{{ float_format($expense->remaining) }}</td>
                    </tr>--}}
                    <tr>
                        <td>Issued on</td>
                        <td>{{ format_datetime($expense->created_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <legend>Payment Details</legend>
        @if(count($expense->payments) < 1)
            No payment records
        @else
            <table class="table">
                <thead>
                    <th>Amount Paid</th>
                    <th>Payment Date</th>
                    <th>Payment Method</th>
                </thead>
                <tbody>
                @foreach($expense->payments as $payment)
                    <tr>
                        <td>{{ float_format($payment->amount_paid) }}</td>
                        <td>{{ readable_date($payment->payment_date) }}</td>
                        <td>{{ ($payment->payment_method == 1) ? 'Cash' : 'Bank Account' }}</td>
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
