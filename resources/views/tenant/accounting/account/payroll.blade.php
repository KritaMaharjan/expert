@extends('tenant.layouts.main')

@section('heading')
Payroll Report
@stop


@section('breadcrumb')
    @parent
    <li>Accounting</li>
    <li>Payroll Report</li>
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
            @include('flash::message')
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
                  <select class="form-control half-width2 pull-left" name="year" id="year">
                    <option value="">Select year</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                  </select>
                <div class="date-box">                    
                    <select class="form-control" name="month" id="month">
                      <option value="">Select month</option>
                      <option value="01">January</option>
                      <option value="02">February</option>
                      <option value="03">March</option>
                      <option value="04">April</option>
                      <option value="05">May</option>
                      <option value="06">June</option>
                      <option value="07">July</option>
                      <option value="08">August</option>
                      <option value="09">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select>                   
                  </div>
                </div>
                <div class="form-group"> 
                    {!! Form::label('user_id', 'Name of Employee') !!}
                    <div class="date-box sel-2-wrap">{!! Form::select('user_id', array('' => 'Select Employee'), null, array('class' => 'form-control pull-left', 'id' => 'select-employee')) !!}</div>
                  </div>
                </form>
              </div>              
            </div>
            <div class="row">
              <div class="col-xs-12 mainContainer">
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