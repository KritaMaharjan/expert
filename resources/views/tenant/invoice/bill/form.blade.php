<!-- info row -->
  <div class="row invoice-info">

    <div class="col-sm-5 invoice-col col-xs-6">

        <div class="form-group clearfix">
          <label>Invoice Number: </label>{{ $company_details['invoice_number'] or $bill->invoice_number }}
        </div>
        <div class="form-group clearfix sel-2 {{ ($errors->has('customer'))? 'has-error': '' }}">
         {!! Form::label('customer', 'Select customer') !!}
         @if(isset($bill) && !empty($bill->customer))
            {!! Form::select('customer', array($bill->customer_id => $bill->customer), $bill->customer_id, array('class' => 'select-customer form-control', 'required' => 'required')) !!}
         @else
            {!! Form::select('customer', array('' => 'Select Customer'), null, array('class' => 'select-customer form-control', 'required' => 'required')) !!}
         @endif
         @if($errors->has('customer'))
             {!! $errors->first('customer', '<label class="control-label error" for="inputError">:message</label>') !!}
         @endif
          <p class="align-right mg-adj">
            <a data-target="#fb-modal" data-url="#customer-modal-data" data-toggle="modal" id="customer-add">
                 Add new Customer
            </a>
            {{--<a href="{{ tenant_route('tenant.customer') }}">Add customer</a>--}}
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

      <div class="right-from align-right">
        {{--<div class="form-group clearfix">
          {!! Form::label('invoice_number', 'Invoice number') !!}
          {!! Form:: text('invoice_number', null, array('class' => 'form-control')) !!}
          @if($errors->has('invoice_number'))
              {!! $errors->first('invoice_number', '<label class="control-label" for="inputError">:message</label>') !!}
          @endif
        </div>--}}
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
        <div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
          {!! Form::label('due_date', 'Due date') !!}

          <div class='input-group date date-box' id='due-date-picker'>
              {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'due-date-pickers')) !!}
              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>

        </div>
         @if($errors->has('due_date'))
                      {!! $errors->first('due_date', '<label class="control-label error" style="position: relative;top: -10px;"for="inputError">:message</label>') !!}
                  @endif
        <div class="form-group clearfix" style="text-align: left!important;">
          {!! Form::label('account_number', 'Account no') !!}
          <span class="border-bx block">{{ $company_details['account_no'] }}</span>
        </div>
        <div class="form-group clearfix">
          {!! Form::label('currency', 'Currency') !!}
          {!! Form::select('currency', $currencies, null, array('class' => 'form-control')) !!}
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
                <select name="product[]" class="select-product form-control">
                    <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                </select>

            </td>

            <td>
                <input type="number" name="quantity[]" class="add-quantity quantity form-control" id="quantity" value="{{$product->quantity}}" required="required" />
            </td>
            <td><span class="border-bx block price">{{ $product->price }} </span></td>
            <td><span class="border-bx block vat">{{ $product->vat }} </span></td>
            <td class="position-relative">
                <div class="action-buttons">
                    <a title="Delete line" class="invoice-delete fa fa-close btn-danger" href="#"></a>
                </div>
                <span class="border-bx block total">{{ $product->total }} </span>
            </td>

          </tr>
            @endforeach
          @else
          <tr class="position-r">
              <td>
                <select name="product[]" class="select-product form-control">
                    <option value="">Select Product</option>
                </select>
              {{--{!! Form::select('product[]', array('' => 'Select Product'), null, array('class' => 'select-product form-control')) !!}--}}
              </td>

              <td>
                <input type="number" name="quantity[]" class="add-quantity quantity form-control" id="quantity" required="required" />
                {{--{!! Form:: text('number', 'quantity[]', null, array('class' => 'form-control add-quantity quantity', 'id' => 'quantity', 'required'=>'required')) !!}--}}</td>
              <td><span class="border-bx block price"> </span></td>
              <td><span class="border-bx block vat"> </span></td>
              <td class="position-relative">
                <div class="action-buttons">
                    <a title="Delete" class="invoice-delete fa fa-close btn-danger" href="#"></a>
                </div>
                <span class="border-bx block total"> </span>
              </td>
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

{{-- Customer Add Modal--}}
<div id="customer-modal-data" class="hide">
    <div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">Add New Customer</h3>
        </div>
        @include('tenant.customer.createCustomer')
    </div><!-- /.box-body -->
</div>

{{--Load JS--}}
{{FB::registerModal()}}
{{FB::js('assets/js/customer.js')}}