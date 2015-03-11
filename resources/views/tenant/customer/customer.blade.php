@extends('tenant.layouts.main')

@section('heading')
Customers
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> Customers</li>
@stop


@section('content')
{{--<link href="{{assets('assets/plugins/iCheck/all.css')}}" rel="stylesheet" type="text/css" />
<link href="{{assets('assets/plugins/iCheck/minimal/blue.css')}}" rel="stylesheet" type="text/css" />--}}

	


  <div class="row">
		<div class="col-md-12 mainContainer">
      
	    	<div class="box box-solid">
          <p class="align-right btn-inside">
            <a class="btn btn-primary" data-toggle="modal" data-url="#customer-modal-data" data-target="#fb-modal">
                 <i class="fa fa-plus"></i> Add new Customer
            </a>
         </p>

         <p class="align-right btn-inside">
            <a class="btn btn-primary" data-toggle="modal" data-url="#test-modal-data" data-target="#fb-modal">
                 <i class="fa fa-plus"></i> Test Upload
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
                     <th></th>
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
        <div id="test-modal-data" class="hide">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Add New Customer</h3>
            </div>
            {!! Form::open(array('route' => 'test.upload','files'=>true, 'id'=>'test-form')) !!}
  
            {!! Form::label('file','File',array('id'=>'','class'=>'')) !!}
            {!! Form::file('file','',array('id'=>'','class'=>'')) !!}
            <br/>
            <!-- submit buttons -->
            {!! Form::submit('Save') !!}
            
            <!-- reset buttons -->
            {!! Form::reset('Reset') !!}
            
            {!! Form::close() !!}
        </div><!-- /.box-body -->
               
        </div>
    </div>
	  	
    </div>

    {{--Load JS--}}
    {{FB::registerModal()}}
   
    {{FB::js('assets/js/customer.js')}}
   

	@stop

