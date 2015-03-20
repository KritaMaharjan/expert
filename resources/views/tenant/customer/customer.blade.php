@extends('tenant.layouts.main')

@section('heading')
Customers
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> Customers</li>
@stop


@section('content')
<style>
ul.ui-autocomplete.ui-menu {
  z-index: 1000 !important;
}
</style>
{{--<link href="{{assets('assets/plugins/iCheck/all.css')}}" rel="stylesheet" type="text/css" />
<link href="{{assets('assets/plugins/iCheck/minimal/blue.css')}}" rel="stylesheet" type="text/css" />--}}

  <div class="row">
		<div class="col-md-12 mainContainer">
      
	    	<div class="box box-solid">
          <p class="align-right btn-inside">
<<<<<<< HEAD
            <a class="btn btn-primary " id="customer-add" data-toggle="modal" data-url="#customer-modal-data" data-target="#fb-modal">
=======
            <a class="btn btn-primary" id="customer-add" data-toggle="modal" data-url="#customer-modal-data" data-target="#fb-modal">
>>>>>>> e001955c2dcce9fb16e93b928b8d7d67faeadedb
                 <i class="fa fa-plus"></i> Add new Customer
                 
            </a>
           
         </p>
         
		    <div class="box-body">
		      <table id="table-customer" class="table table-hover">
               <thead>
                   <tr>
                     <th>ID</th>
                     <th>Customer name</th>
                     <th>Email</th>
                     <th>Added Date</th>
                     <th>Action</th>
                   </tr>
               </thead>
             </table>
		    </div><!-- /.box-body -->
		  </div><!-- /.box -->
	  	</div>

        <div id="customer-modal-data" class="hide">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Add New Customer</h3>
            </div>
            @include('tenant.customer.createCustomer')
                   </div><!-- /.box-body -->
               
        </div>
    </div>
	  	
    </div>
    <script type="text/javascript">

    var customer;
        $(document).on('click','#customer-add', function(){
            $(".js-example-basic-multiple").select2('destroy');
           customer = $('#fb-modal').find('.modal-body').html();
           $('#fb-modal').find('.modal-body').html($('#customer-modal-data').html());
        });
    </script>

    <script type="text/javascript">

    var customer;
        $(document).on('click','#customer-add', function(){
            $(".js-example-basic-multiple").select2('destroy');
           customer = $('#fb-modal').find('.modal-body').html();
           $('#fb-modal').find('.modal-body').html($('#customer-modal-data').html());
        });
    </script>

    {{--Load JS--}}
    {{FB::registerModal()}}
   
    {{FB::js('assets/js/customer.js')}}
       
	@stop
  
