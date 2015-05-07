@extends('tenant.layouts.main')
@section('heading')
Statistics
@stop

@section('breadcrumb')
    @parent
    <li><a data-push="true" href="{{tenant_route('tenant.invoice.index')}}"><i class="fa fa-bar-chart"></i> Statistics</a></li>
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
                  
                  <div class="box-body chart-responsive">
                    <div class="chart" id="line-chart" style="height: 300px;"></div>
                  </div><!-- /.box-body -->
                </div><!-- /.box -->

              </div>
              <div class="col-md-4 pad-top-100">
                <form>
                  <div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
                    {!! Form::label('due_date', 'Date from') !!}

                    <div class='input-group date date-box2' id='due-date-picker'>
                        {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'date-frm-date-pickers')) !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                  <div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
                    {!! Form::label('due_date', 'Date to') !!}

                    <div class='input-group date date-box2' id='due-date-picker'>
                        {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'date-to-date-pickers')) !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div> -->
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="stat-info">
                <div class="col-md-3 ">
                   <h3 class="line-yellow">Customers</h3> 
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
                    <h3  class="line-green">Billing</h3> 
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
                   <h3  class="line-purple">Collection</h3> 
                   <div class="form-group">
                     <label>Number of cases:</label>
                     <span>45</span>                   
                   </div>
                   <div class="form-group">
                     <label>Number of bills:</label>
                     <span>10</span>                   
                   </div>
                   <div class="form-group">
                     <label>Total amount:</label>
                     <span>1,500,000</span>                   
                   </div>
                   <div class="form-group">
                     <label>Purring:</label>
                     <div>
                       <span>0 cases</span>                   
                       <span>0,00 NOK</span>   
                     </div>                
                   </div>
                   <div class="form-group">
                     <label>Inkassovarsel:</label>
                     <div>
                       <span>0 cases</span>                   
                       <span>0,00 NOK</span>   
                     </div>                
                   </div>
                   <div class="form-group">
                     <label>Betalingsoppfordring :</label>
                     <div>
                       <span>0 cases</span>                   
                       <span>0,00 NOK</span>   
                     </div>                
                   </div>
                   <div class="form-group">
                     <label>Betalingsoppfordring :</label>
                     <div>
                       <span>0 cases</span>                   
                       <span>0,00 NOK</span>   
                     </div>                
                   </div>   
                </div>
                <div class="col-md-3">
                    <h3  class="line-red">Accounts</h3>
                    <div class="form-group">
                     <label>Income:</label>
                     <span>15,000,000- NOK</span>                   
                   </div>
                   <div class="form-group">
                     <label>Expenses:</label>
                     <span>12,500,000,- NOK</span>                   
                   </div>
                   <div class="form-group">
                     <label>Salaries:</label>
                     <span>7,500,000,- NOK</span>                   
                   </div>
                   <div class="form-group">
                     <label>Advertising expenses:</label>
                     <span>5,500,500,- NOK</span>                   
                   </div>                 
                   <div class="form-group">
                     <label>Cost of sale:</label>
                     <span>250,000,- NOK</span>                   
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
    <script src="{{ asset('assets/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}" type="text/javascript"></script>
     <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}" type="text/javascript"></script>
     <script type="text/javascript">
      // LINE CHART
        var line = new Morris.Line({
          element: 'line-chart',
          resize: true,
          data: [
            {y: '2011 Q1', item1: 2666, item2: 2666, item3: 15666, item4: 13666},
            {y: '2011 Q2', item1: 2778, item2: 2294, item3: 14666, item4: 12666},
            {y: '2011 Q3', item1: 4912, item2: 1969, item3: 10066, item4: 9666},
            {y: '2011 Q4', item1: 3767, item2: 3597, item3: 13066, item4: 11666},
            {y: '2012 Q1', item1: 6810, item2: 1914, item3: 3566, item4: 12666},
            {y: '2012 Q2', item1: 5670, item2: 4293, item3: 2696, item4: 9666},
            {y: '2012 Q3', item1: 4820, item2: 3795, item3: 1666, item4: 12666},
            {y: '2012 Q4', item1: 15073, item2: 5967, item3: 4666, item4: 11666},
            {y: '2013 Q1', item1: 10687, item2: 4460, item3: 3666, item4: 6666},
            {y: '2013 Q2', item1: 8432, item2: 5713, item3: 2866, item4: 7666}
          ],
          xkey: 'y',
          ykeys: ['item1', 'item2', 'item3', 'item4'],
          labels: ['Customers', 'Billing', 'Collection', 'Statistics'],
          lineColors: ['#fd9d11','#237a7a','#7070a0','#d45127'],
          hideHover: 'auto'
        });
    </script>


 {{ FB::js('$(function(){
        $("#date-frm-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });
        $("#date-to-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });

  })')}}


@stop