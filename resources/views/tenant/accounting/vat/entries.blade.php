@if(count($vat_entries) > 0)
    <table class="table table-striped product-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Vat</th>
                <th>Amount</th>
                <th>Created Date</th>
            </tr>
        </thead>

        <tbody>
            @foreach($vat_entries as $vat)
                <tr>
                    <td>{{ $vat->account_code }}</td>
                    <td>{{ $vat->description }}</td>
                    <td>{{ $vat->amount }}</td>
                    <td>{{ format_datetime($vat->created_at) }}</td>
                </tr>
            @endforeach
        </tbody>
        <!--<tbody>
            <tr>
                <td>Post 1</td>
                <td>Total VAT <font class="uppercase">billed</font> (total amount in accounts 3000-3090 + 3200+3280)</td>
            </tr>
            <tr>
                <td>Post 2</td>
                <td>Sum of post 3, post 4, post 5, post 6. (the amounts without the VAT included)</td>
            </tr>
            <tr>
                <td>Post 3</td>
                <td>Total Exempt VAT, (Total amount in accounts 3100)</td>
            </tr>
            <tr>
                <td>Post 4</td>
                <td>Total high VAT: (Total amount in accounts 3000-3020)</td>
            </tr>
            <tr>
                <td>Post 5</td>
                <td>Total medium VAT: (Total amount in accounts 3030-3040)</td>
            </tr>
            <tr>
                <td>Post 6</td>
                <td>Total low VAT: (Total amount in accounts 3050)</td>
            </tr>
            <tr>
                <td>Post 7</td>
                <td>Total export VAT: (Total amount in accounts 3200-3280)</td>
            </tr>
            <tr>
                <td>Post 8</td>
                <td>Total high VAT: (when expenses with VAT is paid: (total of account 2711))</td>
            </tr>
            <tr>
                <td>Post 9</td>
                <td>Paid medium VAT: (total of account 2713)</td>
            </tr>
            <tr>
                <td>Post 10</td>
                <td>Paid low VAT: (Total of account 2714)</td>
            </tr>
        </tbody>-->
    </table>

    {!! Form::open(array('method'=>'POST', 'class' => 'action-form sent-form', 'dataAction' => 'sent')) !!}
        <div class="form-group">
            {!! Form::label('sent_date', 'This has been sent on :') !!}
            {!! Form::text('sent_date', null, array('class' => 'date-picker form-control', 'id' => 'sent_date')) !!}
        </div>
        {!! Form::button('Mark as sent', array('class'=>'btn btn-primary pull-right form-submit', 'type'=>'submit')) !!}
    {!! Form::close() !!}

    {!! Form::open(array('method'=>'POST', 'class' => 'action-form paid-form', 'dataAction' => 'paid')) !!}
        <div class="form-group">
            {!! Form::label('paid_date', 'This has been paid on :') !!}
            {!! Form::text('paid_date', null, array('class' => 'date-picker form-control', 'id' => 'paid_date')) !!}
        </div>
        {!! Form::button('Mark as paid', array('class'=>'btn btn-primary pull-right form-submit', 'type'=>'submit')) !!}
    {!! Form::close() !!}

    {{ FB::js('$(".date-picker").datepicker({
       "format": "yyyy-mm-dd"
    })') }}


@else
No VAT transactions found for the selected period.
@endif
