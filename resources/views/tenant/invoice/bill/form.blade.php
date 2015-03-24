<?php
    function format_telephone($phone_number)
    {
       $cleaned = preg_replace('/[^[:digit:]]/', '', $phone_number);
       preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);
       return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
    }
?>

<!-- info row -->
  <div class="row invoice-info">

    <div class="col-sm-5 invoice-col col-xs-6">

        <div class="form-group clearfix">
          {!! Form::label('id', 'Bill No.') !!}
          {!! Form:: text('id', null, array('class' => 'form-control')) !!}
        </div>
        <div class="form-group clearfix">
         {!! Form::label('customer', 'Select customer') !!}
         @if(isset($bill) && !empty($bill->customer))
            {!! Form::select('customer', array($bill->customer_id => $bill->customer), $bill->customer_id, array('class' => 'select-single form-control', 'required' => 'required')) !!}
         @else
            {!! Form::select('customer', array('' => 'Select Customer'), null, array('class' => 'select-single form-control', 'required' => 'required')) !!}
         @endif
          <p class="align-right mg-adj">
            <a href="{{ tenant_route('tenant.customer') }}">Add customer</a>
        </p>
        </div>

      <address class="customer-info">

        @if(isset($bill->customer_details))
            <strong>{{ $bill->customer_details->name }} </strong><br>
            {{ $bill->customer_details->street_name  }} {{ $bill->customer_details->street_number  }} <br>
            {{ $bill->customer_details->town  }} <br>
            Phone: {{ $bill->customer_details->telephone  }} <br>
            Email: {{ $bill->customer_details->email }}
        @endif
      </address>
    </div><!-- /.col -->
     <div class="col-sm-7 invoice-col col-xs-6">
      <address class="address-info">
        <strong>{{ $company_details['company_name'] }}</strong><br>
        {{ $company_details['postal_code'] }}, {{ $company_details['town'] }}<br>
        {{ $company_details['address'] }}<br>
        {!! (isset($company_details['telephone']))? 'Phone: '. format_telephone($company_details['telephone']).'<br/>': " " !!}
        {!! (isset($company_details['service_email']))? 'Email: '. $company_details['service_email'].'<br/>': " " !!}
      </address>

      <div class="right-from">
        <div class="form-group clearfix">
          {!! Form::label('invoice_number', 'Invoice number') !!}
          {!! Form:: text('invoice_number', null, array('class' => 'form-control')) !!}
          @if($errors->has('invoice_number'))
              {!! $errors->first('invoice_number', '<label class="control-label" for="inputError">:message</label>') !!}
          @endif
        </div>
        {{--<div class="form-group clearfix">
          {!! Form::label('kid', 'Kid') !!}
          {!! Form:: text('kid', null, array('class' => 'form-control')) !!}
        </div>--}}
        {{--<div class="form-group clearfix">
          {!! Form::label('customer_id', 'Customer id') !!}
          {!! Form:: text('customer_id', null, array('class' => 'form-control')) !!}
          @if($errors->has('customer_id'))
              {!! $errors->first('customer_id', '<label class="control-label" for="inputError">:message</label>') !!}
          @endif
        </div>--}}
        <div class="form-group clearfix">
          {!! Form::label('due_date', 'Due date') !!}
          {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'due-date-picker')) !!}
          @if($errors->has('due_date'))
              {!! $errors->first('due_date', '<label class="control-label" for="inputError">:message</label>') !!}
          @endif
        </div>
        <div class="form-group clearfix">
          {!! Form::label('account_number', 'Account no') !!}
          <span class="">{{ $company_details['account_no'] }}</span>
        </div>
        <div class="form-group clearfix">
          {!! Form::label('currency', 'Currency') !!}
          {!! Form::select('currency', array(
                                        'NOK' => 'NOK',
                                        'GBP' => 'GBP',
                                        'EUR' => 'EUR',
                                        'USD' => 'USD',
                                        'AUD' => 'AUD',
                                        'NZD' => 'NZD',
                                        'CHF' => 'CHF',
                                        'PLN' => 'PLN',
                                        'DKK' => 'DKK',
                                        'SEK' => 'SEK',
                                        'CNY' => 'CNY'
                            ), null, array('class' => 'form-control')) !!}
        </div>
      </div>

    </div><!-- /.col -->
  </div><!-- /.row -->



  <!-- Table row -->
  <div class="row">
    <div class="col-xs-12 table-responsive pad-0-40">
      <table class="table table-striped product-table">
        <thead>
          <tr>
            <th width="40%">Product name</th>
            <th width="15%">Quantity</th>
            <th width="15%">Price</th>
            <th width="15%">VAT %</th>
            <th width="15%">Total</th>
          </tr>
        </thead>
        <tbody>
          @if(isset($bill) && !empty($bill->products))
            @foreach($bill->products as $product)
                <tr class="position-r">
            <td>
              <div class="action-buttons">
                <div class="delete">
                  <a title="Delete line" class="invoice-delete fa fa-close btn-danger" href="#"></a>
                </div>
              </div>
            {!! Form::select('product[]', array($product->product_id => $product->product_name), $product->id, array('class' => 'select-product form-control')) !!}
            {{--{!! Form:: text('product_name', null, array('class' => 'form-control')) !!}--}}
            </td>

            <td>{!! Form:: input('number', 'quantity[]', $product->quantity, array('class' => 'form-control quantity', 'id' => 'quantity', 'required'=>'required')) !!}</td>
            <td>{!! Form:: text('price', $product->price, array('class' => 'form-control price')) !!}</td>
            <td>{!! Form:: text('vat', $product->vat, array('class' => 'form-control vat')) !!}</td>
            <td>{!! Form:: text('total', $product->total, array('class' => 'form-control total', 'readonly' => 'readonly')) !!}</td>
          </tr>
            @endforeach
          @else
          <tr class="position-r">
              <td>
                <div class="action-buttons">
                  <div class="delete">
                    <a title="Delete line" class="invoice-delete fa fa-close btn-danger" href="#"></a>
                  </div>
                </div>
              {!! Form::select('product[]', array('' => 'Select Product'), null, array('class' => 'select-product form-control')) !!}
              {{--{!! Form:: text('product_name', null, array('class' => 'form-control')) !!}--}}
              </td>

              <td>{!! Form:: input('number', 'quantity[]', null, array('class' => 'form-control quantity', 'id' => 'quantity', 'required'=>'required')) !!}</td>
              <td>{!! Form:: text('price', null, array('class' => 'form-control price')) !!}</td>
              <td>{!! Form:: text('vat', null, array('class' => 'form-control vat')) !!}</td>
              <td>{!! Form:: text('total', null, array('class' => 'form-control total', 'readonly' => 'readonly')) !!}</td>
          </tr>

          @endif

        </tbody>
      </table>
      <span class="btn-table-bottom">
        <a href="javascript:;" class="add-btn btn btn-success" title="Add a product"><i class="fa fa-plus"></i> Add a product</a>
      </span>
    </div><!-- /.col -->
  </div><!-- /.row -->

  <div class="row">
    <!-- accepted payments column -->

    <div class="col-xs-6 pull-right pad-0-40">
      <p class="lead">Summary</p>
      <div class="table-responsive">
        <table class="table">
          <tr>
            <th style="width:50%">Subtotal:</th>
            <td id="subtotal">{{ $bill->subtotal or '' }}</td>
          </tr>
          <tr>
            <th>Tax Amount:</th>
            <td id="tax-amount">{{ $bill->tax or '' }}</td>
          </tr>
          <tr>
            <th>Total:</th>
            <td id="all-total">{{ $bill->total or '' }}</td>
          </tr>
        </table>
      </div>
    </div><!-- /.col -->
  </div><!-- /.row -->