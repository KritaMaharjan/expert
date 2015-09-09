@extends('tenant.layouts.main')

@section('heading') Edit {{ ucfirst(Request::segment(2)) }} @stop

@section('breadcrumb')
    @parent
    <li>Invoice</li>
    <li>{{ ucfirst(Request::segment(2)) }}</li>
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
        <small class="pull-right">Invoice Date: <?php echo date('d-M-Y', strtotime($bill->created_at)) ?></small>
      </h2>
    </div><!-- /.col -->
  </div>

       {!!Form::model($bill,['id'=>'bill-form'])!!}
            @include('tenant.invoice.bill.form')
            <div class="row no-print">
            <div class="col-xs-12">
                {!! Form::button('Submit', array('class'=>'btn btn-primary pull-right', 'type'=>'submit')) !!}
            </div>
            </div>

       {!!Form::close()!!}
</div>

</div>
</div>
</div><!-- /.content -->
</div>


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

<div class="clearfix"></div>

{{FB::js('assets/plugins/slimScroll/jquery.slimScroll.min.js')}}
{{FB::js('assets/plugins/fastclick/fastclick.min.js')}}
{{FB::js('assets/js/select2.js')}}
{{FB::js('assets/js/create-bill.js')}}
@stop