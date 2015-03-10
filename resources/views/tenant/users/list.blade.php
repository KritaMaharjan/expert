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
          <th>Actions</th>
        </tr>
      </thead>
      <!-- <tbody>
        @foreach($all_users as $user)
          <tr>
            <td><a href="{{URL::route('subuser.profile', $user->guid)}}">{{$user->fullname}}</a></td>
            <td>{{ date("d-M-Y",strtotime($user->created_at)) }}</td> 
            <td>{{$user->email}}</td>
            <td>
                @if($user->status == 1)
                  <span class="label label-success">Active</span>
                @elseif($user->status == 2)
                  <span class="label label-warning">Suspended</span>
                @elseif($user->status == 3)
                  <span class="label label-danger">Blocked</span>
                @else
                  <span class="label label-warning">Pending</span>
                @endif
            </td>
            <td>
              <div class="box-tools pull-right">
                <span data-toggle="modal" data-target="#fb-modal" data-url="{{ URL::route('subuser.update', $user->guid) }}">
                  <a data-original-title="Update" data-toggle="tooltip" class="btn btn-box-tool"><i class="fa fa-edit"></i></a>
                </span>
                <a data-original-title="Remove" data-toggle="tooltip" class="btn btn-box-tool" href="{{ URL::route('subuser.delete', $user->guid) }}" onclick="return confirm('Do you really want to delete the sub user?')"><i class="fa fa-times"></i></a>
              
              @if($user->status != 3)  
                <a data-original-title="Block" data-toggle="tooltip" class="btn btn-box-tool" href="{{ URL::route('subuser.block', $user->guid) }}" onclick="return confirm('Do you really want to block the sub user?')"><i class="fa fa-minus-circle"></i></a>
              @else
                <a data-original-title="Unblock" data-toggle="tooltip" class="btn btn-box-tool" href="{{ URL::route('subuser.unblock', $user->guid) }}" onclick="return confirm('Do you really want to unblock the sub user?')"><i class="fa fa-minus-circle color-red"></i></a>
              @endif
              
              </div>
            </td> 
          </tr> 
        @endforeach        
      </tbody> -->
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