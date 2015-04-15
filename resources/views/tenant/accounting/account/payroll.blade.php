@extends('tenant.layouts.main')

@section('heading')
Payroll Report
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-circle-o"></i> Payroll Report</li>
@stop

@section('content')

<div class="row">
        <div class="col-xs-12 mainContainer">
          @include('flash::message')
          <div class="box box-solid">
            <p class="align-right btn-inside">
                 <a class="btn btn-primary" href="{{tenant_route('tenant.accounting.payroll.add')}}">
                       <i class="fa fa-plus"></i> Add new payslip
                 </a>
             </p>
            <div class="box-body table-responsive">
              <table id="table-bill" class="table table-hover table-bill">
                <thead>
                    <tr>
                      <th>Name of Employee</th>
                      <th>Salary type</th>
                      <th>Other payment</th>
                      <th>Payment Date</th>
                      <th>Total paid</th>
                      <th>Action</th>
                    </tr>
                </thead>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
</div>
    {{--Load JS--}}
    {{--{{FB::js('assets/js/bill.js')}}--}}

@stop