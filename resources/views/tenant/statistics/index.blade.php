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
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>                            
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
                   <h3 class="align-center">Customers</h3> 
                   <div class="form-group">
                     <label>Customer total:</label>
                     <span>475</span>                   
                   </div>
                   <div class="form-group">
                     <label>Emails:</label>
                     <span>15000</span>                   
                   </div>
                   <div class="form-group">
                     <label>Reply time:</label>
                     <span>4 days</span>                   
                   </div>
                   <div class="form-group">
                     <label>Active customers:</label>
                     <span>75</span>                   
                   </div>   
                </div>
                <div class="col-md-3">
                    <h3 class="align-center">Billing</h3> 
                    <div class="form-group">
                      <label>Number of bills:</label>
                      <span>475</span>                   
                     </div>
                    <div class="form-group">
                       <label>Total billed:</label>
                       <span>15,000,000</span>                   
                    </div>
                    <div class="form-group">
                       <label>Total amount paid:</label>
                       <span>13,000,000</span>                   
                    </div>
                    <div class="form-group">
                     <label>Average payment time:</label>
                     <span>19 days</span>                   
                  </div>  
                  <div class="form-group">
                     <label>Past due total:</label>
                     <span>1500</span>                   
                  </div>  
                  <div class="form-group">
                     <label>Not sent to collection:</label>
                     <span>1500</span>                   
                  </div>  
                  <div class="form-group">
                     <label>Offers:</label>
                     <span>123</span>                   
                  </div>  
                </div>
                <div class="col-md-3">
                   <h3 class="align-center">Collection</h3> 
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
                     <div class="left-block">
                       <span>0 cases</span>                   
                       <span>0,00 NOK</span>   
                     </div>                
                   </div>
                   <div class="form-group">
                     <label>Inkassovarsel:</label>
                     <div class="left-block">
                       <span>0 cases</span>                   
                       <span>0,00 NOK</span>   
                     </div>                
                   </div>
                   <div class="form-group">
                     <label>Betalingsoppfordring :</label>
                     <div class="left-block">
                       <span>0 cases</span>                   
                       <span>0,00 NOK</span>   
                     </div>                
                   </div>
                   <div class="form-group">
                     <label>Betalingsoppfordring :</label>
                     <div class="left-block">
                       <span>0 cases</span>                   
                       <span>0,00 NOK</span>   
                     </div>                
                   </div>   
                </div>
                <div class="col-md-3">
                    <h3 class="align-center">Statistics</h3> 
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

 {{ FB::js('$(function(){
        $("#date-frm-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });
        $("#date-to-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });

  })')}}

@stop