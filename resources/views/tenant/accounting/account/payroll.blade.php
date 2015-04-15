@extends('tenant.layouts.main')

@section('heading')
Payroll Report
@stop


@section('breadcrumb')
    @parent
    <li><i class="fa fa-circle-o"></i> Payroll Report</li>
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
            <div class="box-header pad-0">
                <h3 class="box-title">Payroll overview</h3>
                <a class="btn btn-primary pull-right" href="{{tenant_route('tenant.accounting.payroll.add')}}">
                     <i class="fa fa-plus"></i> Add new payslip
                </a>
            </div>

            <div class="row"> 
              <div class="col-md-6">
                <form>
                  
                <div class="form-group clearfix">
                  <select class="form-control half-width2 pull-left">
                    <option>Select year</option>
                    <option>2015</option>
                    <option>2016</option>
                  </select>
                <div class="date-box">                    
                    <select class="form-control">
                      <option>Select month</option>
                      <option>January</option>
                      <option>February</option>
                      <option>March</option>
                      <option>April</option>
                      <option>May</option>
                      <option>June</option>
                      <option>July</option>
                      <option>August</option>
                      <option>September</option>
                      <option>October</option>
                      <option>November</option>
                      <option>December</option>
                    </select>                   
                  </div>
                </div>
                <div class="form-group"> 
                    {!! Form::label('user_id', 'Name of Employee') !!}
                    <div class="date-box">{!! Form::select('user_id', array('' => 'Select Employee'), null, array('class' => 'form-control pull-left', 'id' => 'select-employee')) !!}</div>
                  </div>
                </form>
              </div>              
            </div>
            <div class="row">
              <div class="col-xs-12 mainContainer">
                @include('flash::message')
               
                  <div class="box-body table-responsive pad-lt-0">
                  
                  <div class="payout-info"></div>
                    
                  </div><!-- /.box-body -->
                </div><!-- /.box -->
              </div>
            </div>  
  </div>

    {{--Load JS--}}
    {{FB::js('assets/js/payroll-report.js')}}

@stop