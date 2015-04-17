@extends('tenant.layouts.main')

@section('heading')
Accounting Expenses
@stop
@section('content')
    <div class="box box-solid">
        <div class="box-body">
        	<div class="box-header pad-0">
                <h3 class="box-title">Accounting expenses</h3>
            </div>

            {!!Form::open(['id'=>'expense-form', 'enctype'=>'multipart/form-data', 'files'=>true])!!}
                <div class="row mg-btm-40">

                    <div class="col-md-6">
                            <div class="form-group clearfix">
                                {!! Form::select('type', [1 => 'From supplier', 2 => 'Cash purchase'], null, array('class' => 'form-control half-width2 pull-left source', 'id' => 'source')) !!}
                                <div class="date-box supplier {{ ($errors->has('supplier_id'))? 'has-error': '' }}">
                                    <select name="supplier_id" class="form-control select-supplier">
                                        <option value="">Select supplier</option>
                                    </select>

                                    @if($errors->has('supplier_id'))
                                         {!! $errors->first('supplier_id', '<label class="control-label error error-right" for="inputError">:message</label>') !!}
                                    @endif

                                    <p class="align-right pad-top-10">
                                        <a class="btn btn-default btn-small" id="supplier-add" data-toggle="modal" data-url="#supplier-modal-data" data-target="#fb-modal">
                                             New
                                        </a>
                                    </p>

                                </div>
                            </div>
                            <div class="form-group clearfix {{ ($errors->has('billing_date'))? 'has-error': '' }}">
                                {!! Form::label('billing_date', 'Billing date') !!}
                                <div class='input-group date date-box' id='due-date-picker'>
                                      {!! Form:: text('billing_date', null, array('class' => 'form-control', 'id' =>'billing-date-pickers')) !!}
                                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                      </span>
                                </div>

                                @if($errors->has('billing_date'))
                                     {!! $errors->first('billing_date', '<label class="control-label error error-right" for="inputError">:message</label>') !!}
                                @endif

                            </div>
                            <div class="form-group clearfix {{ ($errors->has('payment_due_date'))? 'has-error': '' }}">
                                {!! Form::label('payment_due_date', 'Payment due date') !!}

                                <div class='input-group date date-box' id='due-date-picker'>
                                    {!! Form:: text('payment_due_date', null, array('class' => 'form-control', 'id' =>'payment-date-pickers')) !!}
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>

                                @if($errors->has('payment_due_date'))
                                     {!! $errors->first('payment_due_date', '<label class="control-label error error-right" for="inputError">:message</label>') !!}
                                @endif

                            </div>
                            <div class="form-group clearfix {{ ($errors->has('invoice_number'))? 'has-error': '' }}">
                                {!! Form::label('', 'Invoice number') !!}
                                {!! Form:: text('invoice_number', null, array('class' => 'form-control date-box')) !!}

                                @if($errors->has('invoice_number'))
                                     {!! $errors->first('invoice_number', '<label class="control-label error error-right" for="inputError">:message</label>') !!}
                                @endif
                            </div>

                    </div>

                    <div class="col-md-6">
                        <div id="container" >
                              <div id="uploader">
                                    <div class="image-section">
                                        Drop your file
                                    </div>
                              </div>
                        </div>
                        <div id='filelist'>Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 table-responsive  pad-0-40">
                        <table class="table expense-table">
                            <thead>
                                <tr>
                                    <th width="30%">Product</th>
                                    <th width="10%">Amount</th>
                                    <th width="20%">VAT</th>
                                    <th width="10%">Total amount</th>
                                    <th width="30%">Expense account</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="position-r">
                                    <td>
                                        <input type="text" name="text[]" class="form-control" required="required" />
                                    </td>
                                    <td>
                                        {{--{!! Form:: text('amount[]', null, array('class' => 'form-control')) !!}--}}
                                        <input type="text" name="amount[]" class="form-control" id="amount" maxlength="7" required="required" />
                                    </td>
                                    <td>
                                        {{--{!! Form::select('vat[]', $tax, null, array('class' => 'form-control', 'id' => 'vat')) !!}--}}
                                        <select name="vat[]" class="form-control" id="vat">
                                            @foreach($tax as $key => $vat)
                                                <option value="{{$key}}">{{$vat}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <span class="border-bx block total"> </span>

                                    </td>
                                    <td class="position-relative">
                                        {{--{!! Form::select('account_code_id[]', $accounts, null, array('class' => 'select-product', 'id' => 'account-code')) !!}--}}
                                        <select name="account_code_id[]" class="select-product" id="account-code" required="required" >
                                            @foreach($accounts as $key => $account)
                                                <option value="{{$key}}">{{$account}}</option>
                                            @endforeach
                                        </select>

                                        <div class="action-buttons">
                                            <a title="Delete" class="invoice-delete fa fa-close btn-danger" href="javascript:;"></a>
                                        </div>
                                    </td>
                                    <!-- <td>
                                        <span class="border-bx block total"> </span>
                                  </td> -->
                                </tr>

                            </tbody>
                        </table>
                        <span class="btn-table-bottom">
                            <a title="Add a product" class="add-btn btn btn-success" href="javascript:;"><i class="fa fa-plus"></i> Add a product</a>
                        </span>
                    </div>
                    <div class="col-md-12">
                            <div class="form-group">
                                <label id="paid-box">{!! Form::checkbox('is_paid', null, false, array('class' => 'icheck')) !!} &nbsp;&nbsp;The bill is already paid.</label>
                            </div>

                            <div class="row">
                                <div id="after-paid" class="col-md-6">
                                    <div class="form-group clearfix">
                                        {!! Form::label('', 'Paid from') !!}
                                        <div class="date-box">
                                            {!! Form::select('payment_method', [1 => 'Cash', 2 =>'Bank account'] , null, array('class' => 'form-control pull-left')) !!}
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        {!! Form::label('', 'Amount paid') !!}
                                        {!! Form:: text('amount_paid', null, array('class' => 'form-control date-box')) !!}
                                    </div>
                                    <div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
                                        {!! Form::label('due_date', 'Paid date') !!}

                                        <div class='input-group date date-box' id='due-date-picker'>
                                            {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'paid-date-pickers')) !!}
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div><br />
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div>
                                    <button class="btn btn-primary pull-right savebusiness" type="submit">Register expense</button>
                                </div>
                            </div>
                    </div>

                </div>
        	{!! Form::close() !!}
        </div>
    <div>

    <div id="supplier-modal-data" class="hide">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Add New Supplier</h3>
            </div>
            @include('tenant.supplier.createSupplier')
        </div><!-- /.box-body -->
    </div>

    {{ FB::registerModal() }}
    {{ FB::js('assets/js/expense.js') }}
</div>
</div>
@stop


{{FB::js('assets/plugins/plupload/js/plupload.full.min.js')}}
<?php
$successCallback ="
  var response = JSON.parse(object.response);
  var wrap = $('#'+file.id);
  wrap.append('<input type=\"hidden\" class=\"attachment\" name=\"bill_image\" value=\"'+response.data.fileName+'\" />');
  wrap.append('<a href=\"#\" data-action=\"compose\" data-url=\"'+response.data.fileName+'\" class=\"cancel_upload\" ><i class=\"fa fa-times\"></i></a>');
  $('#container').hide();
  $('.bill_image').remove();
  $('#container').before('<img class=\"bill_image\" src='+response.data.pathName+'/>');
";
FB::js(plupload()->button('uploader')->maxSize('20mb')->mimeTypes('image')->url(url('file/upload/data?folder=expense'))->autoStart(true)->success($successCallback)->init());

$js ="$(document).on('click', '.cancel_upload', function (e) {
              e.preventDefault();
              var url = $(this).data('url');
              var wrap = $(this).parent();
              var action = $(this).data('action');

              if (!confirm('Are you sure, you want to delete file?')) return false;

              if (action == 'compose') {
                  $.ajax({
                      url: appUrl + 'file/delete',
                      type: 'GET',
                      dataType: 'json',
                      data: {file: url, folder:'expense'}
                  })
                      .done(function (response) {
                          if (response.status == 1) {
                              wrap.remove();
                              $('.bill_image').remove();
                              $('#container').show();
                          }
                          else {
                              alert(response.data.error);
                          }
                      })
                      .fail(function () {
                          alert('Connect error!');
                      })
              }
              else {
                  wrap.remove();
              }
          });";
FB::js($js);

?>
