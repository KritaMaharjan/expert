@extends('tenant.layouts.main')
@section('heading')
Statistics
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-bar-chart"></i> Statistics</li>
@stop

@section('content')

<div class="row">
  <div class="col-xs-12 mainContainer">
       <div class="box box-solid">
       	 <div class="nav-tabs-custom clearfix">
          <!-- Tabs within a box -->
          <ul class="nav nav-tabs pull-right">
            <!-- <li class="active"><a href="#revenue-chart" data-toggle="tab">Statistics</a></li> -->
            <!-- <li><a href="#sales-chart" data-toggle="tab">Donut</a></li> -->
            <li class="pull-left header"><i class="fa fa-inbox"></i> Statistics</li>
          </ul>
          <div class="tab-content col-md-12">
            <div class="row">
              <div class="col-md-8">
                <!-- LINE CHART -->
                <div class="box box-solid">
                  
                  <div class="box-body chart-box">

                  </div><!-- /.box-body -->
                  <div class="processing" style="display: none"><img src="{{ asset('assets/images/loader.gif')}}"></div>
                  <div class="info-graph">Click on the titles below to view the graph.</div>
                </div><!-- /.box -->

              </div>
              <div class="col-md-4 pad-top-100">
                @if(!isset($filter))
                    {!!Form::open(['id'=>'filter-form', 'method'=>'get'])!!}
                @else
                    {!!Form::model($filter, ['id'=>'filter-form', 'method'=>'get'])!!}
                @endif
                  <div class="form-group clearfix {{ ($errors->has('start_date'))? 'has-error': '' }}">
                    {!! Form::label('start_date', 'Date from') !!}

                    <div class='input-group date date-box2' id='due-date-picker'>
                        {!! Form:: text('start_date', null, array('class' => 'form-control', 'id' =>'date-frm-date-pickers', 'required' => 'required')) !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                  <div class="form-group clearfix {{ ($errors->has('end_date'))? 'has-error': '' }}">
                    {!! Form::label('end_date', 'Date to') !!}

                    <div class='input-group date date-box2' id='due-date-picker'>
                        {!! Form:: text('end_date', null, array('class' => 'form-control', 'id' =>'date-to-date-pickers', 'required' => 'required')) !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>

                  <div class="form-group clearfix">
                       <button class="btn btn-primary pull-right filter-submit" type="submit">Filter</button>
                  </div>
                {!! Form::close() !!}
              </div>
            </div>
            <!-- <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div> -->
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="stat-info">
                <div class="col-md-3 ">
                   <h3 class="graph-heading">Customers</h3>
                   <div class="form-group">
                     <label>Customer total:</label>
                     <span>{{ $customer_stats['total_customers'] }}</span>
                   </div>
                   <div class="form-group">
                     <label>Emails:</label>
                     <span>{{ $customer_stats['total_emails'] }}</span>
                   </div>
                   <div class="form-group">
                     <label>Active customers:</label>
                     <span>{{ $customer_stats['total_active_customers'] }}</span>
                   </div>   
                </div>
                <div class="col-md-3">
                    <h3 class="graph-heading">Billing</h3>
                    <div class="form-group">
                      <label>Number of bills:</label>
                      <span>{{ $bill_stats['total_bills'] }}</span>
                     </div>
                    <div class="form-group">
                       <label>Total billed:</label>
                       <span>{{ float_format($bill_stats['total_billed']) }}</span>
                    </div>
                    <div class="form-group">
                       <label>Total amount paid:</label>
                       <span>{{ float_format($bill_stats['total_paid']) }}</span>
                    </div>
                    <div class="form-group">
                     <label>Average payment time:</label>
                     <span>{{ $bill_stats['avg_payment_time'] }} days</span>
                  </div>  
                  <div class="form-group">
                     <label>Past due total:</label>
                     <span>{{ $bill_stats['past_due'] }}</span>
                  </div>  
                  <div class="form-group">
                     <label>Not sent to collection:</label>
                     <span>{{ $bill_stats['not_collection'] }}</span>
                  </div>  
                  <div class="form-group">
                     <label>Offers:</label>
                     <span>{{ $bill_stats['total_offers'] }}</span>
                  </div>  
                </div>
                <div class="col-md-3">
                   <h3 class="graph-heading">Collection</h3>
                   <div class="form-group">
                     <label>Number of cases:</label>
                     <span>{{ $collection_stats['total_cases'] }}</span>
                   </div>
                   <div class="form-group">
                     <label>Number of bills:</label>
                     <span>{{ $collection_stats['total_bills'] }}</span>
                   </div>
                   <div class="form-group">
                     <label>Total amount:</label>
                     <span>{{ $collection_stats['total_amount'] }}</span>
                   </div>
                   <div class="form-group">
                     <label>Purring:</label>
                     <div>
                       <span>{{ $collection_stats['total_purring']['total'] }} cases</span>
                       <span>{{ $collection_stats['total_purring']['amount'] }} NOK</span>
                     </div>                
                   </div>
                   <div class="form-group">
                     <label>Inkassovarsel :</label>
                     <div>
                       <span>{{ $collection_stats['total_inkassovarsel']['total'] }} cases</span>
                       <span>{{ $collection_stats['total_inkassovarsel']['amount'] }} NOK</span>
                     </div>                
                   </div>
                   <div class="form-group">
                     <label>Betalingsoppfordring :</label>
                     <div>
                       <span>{{ $collection_stats['total_betalingsappfording']['total'] }} cases</span>
                       <span>{{ $collection_stats['total_betalingsappfording']['amount'] }} NOK</span>
                     </div>                
                   </div>   
                </div>
                <div class="col-md-3">
                    <h3 class="graph-heading">Accounts</h3>
                    <div class="form-group">
                     <label>Income:</label>
                     <span>{{ $account_stats['total_income'] }} NOK</span>
                   </div>
                   <div class="form-group">
                     <label>Expenses:</label>
                     <span>{{ $account_stats['total_expenses'] }}- NOK</span>
                   </div>
                   <div class="form-group">
                     <label>Salaries:</label>
                     <span>{{ $account_stats['total_paid_salary'] }}- NOK</span>
                   </div>
                   <div class="form-group">
                     <label>Advertising expenses:</label>
                     <span>5,500,500 NOK</span>
                   </div>                 
                   <div class="form-group">
                     <label>Cost of sale:</label>
                     <span>{{ $account_stats['total_sales_cost'] }} - NOK</span>
                   </div>   
                </div>
              </div>

            </div>
          </div>
        </div>
       </div> 
  </div>
</div>


<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
{{ FB::js('assets/plugins/morris/morris.min.js') }}
{{ FB::js('assets/plugins/morris/morris.min.js') }}
{{ FB::js('assets/plugins/sparkline/jquery.sparkline.min.js') }}
{{ FB::js('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}
{{ FB::js('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}
{{ FB::js('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}

{{ FB::js('assets/js/statistics.js') }}

@stop