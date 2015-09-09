@extends('system.layouts.main')
@section('title')
    My Profile
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
    <div class="box">
        <div class="box-body">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-user"></i> {{ $user->given_name." ".$user->surname }}
                </h3>
                <div class="box-tools"><a href="{{url('system/change-password')}}">Change Password</a></div>
                <small> {{get_role()}}</small>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover table-striped">
                    <tbody>
                    <tr>
                        <td><strong>Username</strong></td>
                        <td>{{$user->username}}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{$user->email}}</td>
                    </tr>
                    <tr>
                        <td><strong>Title</strong></td>
                        <td>{{$user->title}}</td>
                    </tr>
                    <tr>
                        <td><strong>Signup Date and Time</strong></td>
                        <td>{{$user->created_at}}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone Numbers</strong></td>
                        <td>
                            <ul class="list-unstyled">
                            @foreach($user->user_phones as $user_phone)
                                <li><i class="fa {{get_phone_icon($user_phone->phone->type)}}"></i>  {{$user_phone->phone->number}}</li>
                            @endforeach
                            </ul>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <h4><i class="fa fa-map-marker"></i> Address Details</h4>
                @foreach($user->user_addresses as $user_addresses)
                <table class="table table-hover table-striped">
                    <tbody>
                    <tr>
                        <td><strong>Line 1</strong></td>
                        <td>{{$user_addresses->address->line1}}</td>
                    </tr>
                    <tr>
                        <td><strong>Line 2</strong></td>
                        <td>{{$user_addresses->address->line2}}</td>
                    </tr>
                    <tr>
                        <td><strong>Suburb</strong></td>
                        <td>{{$user_addresses->address->suburb}}</td>
                    </tr>
                    <tr>
                        <td><strong>State</strong></td>
                        <td>{{$user_addresses->address->state}}</td>
                    </tr>
                    <tr>
                        <td><strong>Postcode</strong></td>
                        <td>{{$user_addresses->address->postcode}}</td>
                    </tr>
                    <tr>
                        <td><strong>Country</strong></td>
                        <td>{{config('general.countries')[$user_addresses->address->country]}}</td>
                    </tr>
                    </tbody>
                </table>
                <br/>
                @endforeach
            </div>
        </div>
    </div>
@stop