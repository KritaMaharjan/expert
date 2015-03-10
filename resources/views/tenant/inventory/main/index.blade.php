@extends('tenant.layouts.main')

@section('heading')
Inventory
@stop

@section('breadcrumb')
    @parent
    <li><a data-push="true" href="route('tenant.inventory.index')"><i class="fa fa-cog"></i> Inventory</a></li>
    <li><i class="fa fa-cog"></i> Inventory</li>
@stop

@section('content')
<div class="row">
        <div class="col-xs-12 mainContainer">
          <div class="box box-solid">
            <p class="align-right btn-inside">
                 <a class="btn btn-primary" data-toggle="modal" data-url="#inventory-modal-data" data-target="#fb-modal">
                       <i class="fa fa-plus"></i> Add new inventory
                 </a>
             </p>
            <div class="box-body table-responsive">
              <table id="table-inventory" class="table table-hover">
                <thead>
                    <tr>
                      <th>Inventory ID</th>
                      <th>Product name</th>
                      <th>Quantity</th>
                      <th>Total Purchase cost</th>
                      <th>Total Sales price</th>
                      <th>Vat</th>
                      <th>Purchase Date</th>
                      <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
</div>

   @include('tenant.inventory.main.create')
    {{--Load JS--}}
    {{FB::registerModal()}}
    {{FB::js('assets/js/inventory.js')}}
@stop