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
            <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
            <!-- <li><a href="#sales-chart" data-toggle="tab">Donut</a></li> -->
            <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>
          </ul>
          <div class="tab-content no-padding">
            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
            <!-- <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div> -->
          </div>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-3">
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
                
              </div>
              <div class="col-md-3">
                 <h3 class="align-center">Collection</h3> 
                
              </div>
              <div class="col-md-3">
                 <h3 class="align-center">Statistics</h3> 
                
              </div>
            </div>

          </div>
        </div>
       </div> 
  </div>
</div>



@stop