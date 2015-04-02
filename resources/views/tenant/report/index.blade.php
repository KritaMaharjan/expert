@extends('tenant.layouts.main')
@section('heading')
Reports
@stop

@section('breadcrumb')
    @parent
    <li><a data-push="true" href="{{tenant_route('tenant.invoice.index')}}"><i class="fa fa-bar-chart"></i> Reports</a></li>
@stop

@section('content')

<div class="row">
        <div class="col-xs-12 mainContainer">

            {{--content goes here--}}

        </div>
</div>

@stop