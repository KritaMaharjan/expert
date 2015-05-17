@extends('tenant.layouts.main')

@section('heading')
Product
@stop

@section('breadcrumb')
    @parent
    <li><a data-push="true" href="{{tenant_route('tenant.inventory.index')}}">Inventory</a></li>
    <li>Product</li>
@stop


@section('content')

<div class="row">
        <div class="col-xs-12 mainContainer">
           

          <div class="box box-solid">
            <p class="align-right btn-inside">
                 <a class="btn btn-primary" data-toggle="modal" data-url="#product-modal-data" data-target="#fb-modal">
                       <i class="fa fa-plus"></i> Add new product
                 </a>
             </p>
            <div class="box-body table-responsive">
              <table id="table-product" class="table table-hover">
                <thead>
                    <tr>
                      <th>Product ID</th>
                      <th>Product Number</th>
                      <th>Product Name</th>
                      <th>Purchase Cost</th>
                      <th>Sales Price</th>
                      <th>Vat</th>
                      <th>Action</th>
                    </tr>
                </thead>
               
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
</div>
    @include('tenant.inventory.product.create')
    {{--Load JS--}}
    {{FB::registerModal()}}
    {{FB::js('assets/js/product.js')}}

@stop