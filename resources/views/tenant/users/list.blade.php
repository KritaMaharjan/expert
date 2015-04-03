@extends('tenant.layouts.main')

@section('heading')
All Users
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-users"></i> &nbsp;All Users</li>
@stop

@section('content')

  <div class="row">
  <div class="col-md-12 mainContainer">
    
  @include('flash::message')
    <div class="box box-solid">
  <!--<div class="box-header">                  
    <div class="btn-top-ryt">
    <a href="add-customer.html" class="btn btn-primary btn-block btn-flat">Add</a>
    </div>
  </div>--><!-- /.box-header -->
    <p class="align-right btn-inside">
      <a class="btn btn-primary" data-toggle="modal" data-url="#subuser-modal-data" data-target="#fb-modal">
        <i class="fa fa-plus"></i> Add new user
      </a>
    </p>
   
  <div class="box-body">

    <div class="grid-wrap">
    <table id="table-user" class="table table-hover">
      <thead>
        <tr>
          <th>Full Name</th>
          <th>Active Since</th>
          <th>Email Address</th>
          <th>Status</th>
          <th>Register Days</th>
          <th>Actions</th>

        </tr>
      </thead>
    </table>
   </div>
  </div><!-- /.box-body -->
  </div>

  </div>

  @include('tenant.users.create')
  
@stop



{{FB::registerModal()}}
{{FB::js('assets/js/user.js')}}

{{-- {{ FB::js("blockUser.js") }} --}}