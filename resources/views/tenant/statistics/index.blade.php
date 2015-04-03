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
       	 <div class="nav-tabs-custom">
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
        </div>
       </div> 
  </div>
</div>



@stop