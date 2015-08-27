@extends('system.layouts.main')
@section('title')
Client Profile
@stop
@section('heading')
Profile
@stop

@section('breadcrumb')
    @parent
    <li>Profile</li>
    <li>{{$user->username}}</li>
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">

          
                                <div class="box-header">
                                    <h3 class="box-title"></h3>
                                    <a href="{{url('system/change-password')}}">Change Password</a>
                                    <div class="box-tools">
                                        
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tbody>

                                       
                                         <tr>
                                            <td>Email</td>
                                            <td>{{$user->email}}</td>
                                            
                                        </tr>
                                        
                                        
                                        <tr>
                                            <td>Signup Date and Time</td>
                                            <td>{{$user->created_at}}</td>
                                            
                                        </tr>

                                       
                                    </tbody></table>
                               
                            </div>

        </div>

@stop