@extends('tenant.layouts.main')

@section('heading') Create Bill @stop

@section('breadcrumb')
    @parent
    <li><a data-push="true" href="{{tenant_route('tenant.invoice.index')}}"><i class="fa fa-cog"></i> Invoice</a></li>
    <li><i class="fa fa-money"></i> Bill</li>
@stop

@section('content')

<!-- Main content -->
<div class="row">
<div class="col-xs-12 mainContainer">
<div class="box box-solid">

<div class="box-body">

  <!-- title row -->
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        FastBooks
        <small class="pull-right">Date: 3/6/2015</small>
      </h2>
    </div><!-- /.col -->
  </div>

  {!! Form::open(array('method'=>'POST', 'files'=>true, 'id'=>'subuser-form')) !!}
  <!-- info row -->
  <div class="row invoice-info">

    <div class="col-sm-5 invoice-col col-xs-6">

        <div class="form-group clearfix">
          {!! Form::label('invoice_number', 'Bill No.') !!}
          {!! Form:: text('invoice_number', null, array('class' => 'form-control')) !!}
        </div>
        <div class="form-group clearfix">
         {!! Form::label('customer', 'Select customer') !!}
         {!! Form::select('customer', array('' => 'Select Customer'), null, array('class' => 'select-single form-control', 'required' => 'required')) !!}
          <p class="align-right mg-adj">
            <a href="#">Add customer</a>
        </p>
        </div>
        {{--{!! Form::button('Save', array('class'=>'btn btn-primary pull-right subuser-submit', 'type'=>'submit')) !!}--}}

      <address class="customer-info">
      </address>
    </div><!-- /.col -->
     <div class="col-sm-7 invoice-col col-xs-6">
      <address class="address-info">
        <strong>FastBooks</strong><br>
        795 Folsom Ave, Suite 600<br>
        Norway, CA 94107<br>
        Phone: (804) 123-5432<br/>
        Email: info@fastbooks.com
      </address>

      <div class="right-from">
        <div class="form-group clearfix">
          {!! Form::label('created_at', 'Invoice date') !!}
          {!! Form:: input('date', 'created_at', null, array('class' => 'form-control', 'id' => 'invoice-date-picker')) !!}
        </div>
        <div class="form-group clearfix">
          {!! Form::label('invoice_number', 'Invoice number') !!}
          {!! Form:: text('invoice_number', null, array('class' => 'form-control')) !!}
        </div>
        <div class="form-group clearfix">
          {!! Form::label('kid', 'Kid') !!}
          {!! Form:: text('kid', null, array('class' => 'form-control')) !!}
        </div>
        <div class="form-group clearfix">
          {!! Form::label('customer_id', 'Customer id') !!}
          {!! Form:: text('customer_id', null, array('class' => 'form-control', 'disabled'=>'disabled')) !!}
        </div>
        <div class="form-group clearfix">
          {!! Form::label('due_date', 'Due date') !!}
          {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'due-date-picker')) !!}
        </div>
        <div class="form-group clearfix">
          {!! Form::label('account_number', 'Account no') !!}
          {!! Form:: text('account_number', null, array('class' => 'form-control')) !!}
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
                            ), 'NOK', array('class' => 'form-control')) !!}
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
          <tr class="position-r">
            <td>
              <div class="action-buttons">
                <div class="delete">
                  <a title="Delete line" class="invoice-delete fa fa-close btn-danger" href="#"></a>
                </div>
              </div>

            {!! Form::select('product_name', array('' => 'Select Product'), null, array('class' => 'select-product form-control', 'required' => 'required')) !!}
            {{--{!! Form:: text('product_name', null, array('class' => 'form-control')) !!}--}}
            </td>

            <td>{!! Form:: input('number', 'quantity', null, array('class' => 'form-control', 'id' => 'quantity')) !!}</td>
            <td>{!! Form:: text('price', null, array('class' => 'form-control price')) !!}</td>
            <td>{!! Form:: text('vat', null, array('class' => 'form-control vat')) !!}</td>
            <td>{!! Form:: text('total', null, array('class' => 'form-control total', 'readonly' => 'readonly')) !!}</td>
          </tr>



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
      <p class="lead">Amount Due 2/22/2015</p>
      <div class="table-responsive">
        <table class="table">
          <tr>
            <th style="width:50%">Subtotal:</th>
            <td id="subtotal"></td>
          </tr>
          <tr>
            <th>Tax Amount:</th>
            <td id="tax-amount"></td>
          </tr>
          <tr>
            <th>Total:</th>
            <td id="all-total"></td>
          </tr>
        </table>
      </div>
    </div><!-- /.col -->
  </div><!-- /.row -->

  <!-- this row will not appear when printing -->
  <div class="row no-print">
    <div class="col-xs-12">
      <button class="btn btn-primary pull-right" style="margin-right: 5px;">Submit</button>
    </div>
  </div>

  {!! Form::close() !!}
</div>
</div>
</div><!-- /.content -->
</div>
<div class="clearfix"></div>
    {{FB::js('assets/plugins/slimScroll/jquery.slimScroll.min.js')}}
    {{FB::js('assets/plugins/fastclick/fastclick.min.js')}}
    {{FB::js('assets/js/select2.js')}}
    {{FB::js('assets/js/create-bill.js')}}
@stop


