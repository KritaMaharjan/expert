@extends('tenant.layouts.main')

@section('heading')
Profile
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> Profile</li>
    <li>{{$user->username}}</li>
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">

          
            <div class="box-header align-right">
                            <h3 class="box-title"></h3>
                            <a href="{{tenant_route('tenant.auth.changePassword')}}" class="mg-right-5">Change password</a>
                            <a href="{{tenant_route('tenant.auth.changePassword')}}">Settings</a>
                            <div class="box-tools">

                            </div>
                        </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><strong>Name</strong></td>
                            <td>{{$user->fullname}}</td>                                
                        </tr>
                        <tr>
                            <td><strong>Domain</strong></td>
                            <td>{{$user->domain}}</td>
                            
                        </tr>
                         <tr>
                            <td><strong>Email</strong></td>
                            <td>{{$user->email}}</td>
                            
                        </tr>
                         <tr>
                            <td><strong>Company name</strong></td>
                            <td>{{$user->company}}</td>
                            
                        </tr>
                        
                         <tr>
                            <td><strong>Status<strong></td>
                            <td>@if($user->status == 1) Active @elseif($user->status == 0) Inactive @endif</td>
                            
                        </tr>
                        <tr>
                            <td><strong>Registration Date</strong></td>
                            <td>{{$user->created_at}}</td>
                            
                        </tr>
                    </tbody>
                </table>
           
            </div>

        </div>

@stop