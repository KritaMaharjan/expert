@extends('tenant.layouts.main')

@section('heading')
Suppliers
@stop

@section('breadcrumb')
    @parent
    <li>Suppliers</li>
@stop

@section('content')

  <div class="row">
		<div class="col-md-12 mainContainer">
      
        <div class="box box-solid">
            <p class="align-right btn-inside">
                <a class="btn btn-primary" id="supplier-add" data-toggle="modal" data-url="#supplier-modal-data" data-target="#fb-modal">
                     <i class="fa fa-plus"></i> Add new Supplier
                </a>
            </p>
         
		    <div class="box-body">
                <div class="table-responsive">
    		      <table id="table-supplier" class="table table-hover">
                   <thead>
                       <tr>
                         <th>ID</th>
                         <th>Supplier name</th>
                         <th>Email</th>
                         <th>Added Date</th>
                         <th>Action</th>
                       </tr>
                   </thead>
                 </table>
                 </div>
		    </div><!-- /.box-body -->
		 </div><!-- /.box -->
	  	</div>

        <div id="supplier-modal-data" class="hide">
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">Add New Supplier</h3>
                </div>
                @include('tenant.supplier.createSupplier')
            </div><!-- /.box-body -->
        </div>
    </div>
	  	
    </div>


   
    {{--Load JS--}}
    {{FB::registerModal()}}
   
    {{FB::js('assets/js/supplier.js')}}

       
	@stop
  
