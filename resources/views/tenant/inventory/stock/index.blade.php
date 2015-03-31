@extends('tenant.layouts.main')

@section('heading')
Stock
@stop

@section('breadcrumb')
    @parent
    <li><a data-push="true" href="{{tenant_route('tenant.inventory.index')}}"><i class="fa fa-cog"></i> Inventory</a></li>
    <li><i class="fa fa-cog"></i> Stock</li>
@stop


@section('content')

<div class="row">
        <div class="col-xs-12 mainContainer">
           

          <div class="box box-solid">
           
            <div class="box-body table-responsive" id="stock-list">
            @include('tenant.inventory.stock.list')
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
</div>
   
    {{--Load JS--}}

    {{FB::js('assets/js/stock.js')}}

    @stop


    


