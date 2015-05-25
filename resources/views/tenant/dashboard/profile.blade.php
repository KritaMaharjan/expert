@extends('tenant.layouts.main')

@section('heading')
Profile
@stop

@section('breadcrumb')
    @parent
    <li>Profile</li>
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">

          
            <div class="box-header align-right">
                <h3 class="box-title"></h3>
                <a href="{{tenant_route('tenant.auth.changePassword')}}" class="mg-right-5 btn btn-default btn-small">Change password</a>
                <a href="{{tenant_route('tenant.edit.profile')}}"  title="Profile" class="btn btn-default btn-small"> Edit profile</a>
                <div class="box-tools">

                </div>
            </div><!-- /.box-header -->

            <div class="box-body table-responsive no-padding">
                <table class="table table-striped">
                    <tbody>

                        <tr>
                            <td><strong>Profile image</strong></td>
                            <td>
                              @if(isset($user->photo) && $user->photo !='')
                               @if(file_exists(base_path('public_html/assets/uploads/'.$user->photo)))
                               <img src="{{ asset('assets/uploads/'.$user->photo)}}" class="uploaded-img2">
                              @else
                                <img src="{{ asset('assets/images/no_image.jpg') }}" class="uploaded-img2">
                            
                             @endif     
                             @else 
                               <img src="{{ asset('assets/images/no_image.jpg') }}" class="uploaded-img2">
                             @endif                       
                        </tr>
                        <tr>
                            <td><strong>Name</strong></td>
                            <td>{{$user->fullname or ''}}</td>                                
                        </tr>
                      <!--   <tr>
                            <td><strong>Domain</strong></td>
                            <td>{{$user->domain}}</td>
                            
                        </tr> -->
                         <tr>
                            <td><strong>Email</strong></td>
                            <td>{{$user->email or '' }}</td>
                            
                        </tr>
                        <!--  <tr>
                            <td><strong>Company name</strong></td>
                            <td>{{$user->company}}</td>
                            
                        </tr> -->

                        <tr>
                            <td><strong>Address</strong></td>
                            <td>{{$user->address or '' }}</td>
                            
                        </tr>


                        <tr>
                            <td><strong>Social Security Number</strong></td>
                            <td>{{$user->social_security_number or '' }}</td>
                            
                        </tr>

                        <tr>
                            <td><strong>Phone</strong></td>
                            <td>{{$user->phone or ''}}</td>
                            
                        </tr>
                        <tr>
                            <td><strong>Post Code </strong></td>
                            <td>{{$user->postcode or ''}}</td>
                            
                        </tr>

                        <tr>
                            <td><strong>Town </strong></td>
                            <td>{{$user->town or ''}}</td>
                            
                        </tr>

                        
                         <tr>
                            <td><strong>Tax Card </strong></td>
                            <td>{{$user->tax_card or ''}}</td>
                            
                        </tr> 
                        <tr>
                            <td><strong>Registration Date</strong></td>
                            <td>{{$user->created_at or ''}}</td>
                            
                        </tr>
                    </tbody>
                </table>
           
            </div>

        </div>

@stop