@extends('tenant.layouts.main')

@section('heading')
Bill
@stop

@section('breadcrumb')
    @parent
    <li><a data-push="true" href="{{tenant_route('tenant.invoice.index')}}"><i class="fa fa-cog"></i> Invoice</a></li>
    <li><i class="fa fa-cog"></i> Bill</li>
@stop


@section('content')

<div class="row">
        <div class="col-xs-12 mainContainer">
          <div class="box box-solid">
            <p class="align-right btn-inside">
                 <a class="btn btn-primary" href="{{tenant_route('tenant.invoice.bill.add')}}">
                       <i class="fa fa-plus"></i> Add new bill
                 </a>
             </p>
            <div class="box-body table-responsive">
              <table id="table-bill" class="table table-hover">
                <thead>
                    <tr>
                      <th>Bill Number</th>
                      <th>Customer</th>
                      <th>Invoice Date</th>
                      <th>Vat</th>
                      <th>Total</th>
                      <th>Action</th>
                    </tr>
                </thead>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
</div>
    {{--Load JS--}}
    {{FB::js('assets/js/bill.js')}}

@stop