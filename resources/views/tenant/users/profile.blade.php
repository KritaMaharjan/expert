@extends('tenant.layouts.main')

@section('heading')
User Details
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-users"></i> User</li>
    <li><i class="fa fa-user"></i> Profile</li>
@stop

@section('content')

  <div class="box box-solid">
    <div class="box-body table-responsive">
      <table class="table">
          <tbody>
              <tr>
                  <td class="no-border"><strong>Name</strong></td>
                  <td class="no-border">{{ $user->fullname }}</td>                                
              </tr>
              <tr>
                  <td><strong>Email</strong></td>
                  <td>{{ $user->email }}</td>
                  
              </tr>
               <tr>
                  <td><strong>Status</strong></td>
                  <td>@if($user->status == 0)
                        Pending
                      @elseif($user->status == 1)
                        Activated
                      @elseif($user->status == 2)
                        Suspended
                      @else
                        Blocked
                      @endif
                  </td>
                  
              </tr>
               <tr>
                  <td><strong>Last Login</strong></td>
                  <td>{{{ ($user->last_login)? date("d-M-Y h:i:s A",strtotime($user->last_login)) : 'N/A' }}}</td>
                  
              </tr>
              
               <tr>
                  <td><strong>Created Date</strong></td>
                  <td>{{ date("d-M-Y h:i:s A",strtotime($user->created_at)) }}</td>
                  
              </tr>
              <tr>
                  <td><strong>Phone</strong></td>
                  <td>{{ $profile->phone or 'Not saved'}}</td>
                  
              </tr>
               <tr>
                  <td><strong>Address</strong></td>
                  <td>{{ $profile->address }}</td>
                  
              </tr>
              
               <tr>
                  <td><strong>Postcode</strong></td>
                  <td>{{ $profile->postcode or 'Not saved' }}</td>
                  
              </tr>
              <tr>
                  <td><strong>Town</strong></td>
                  <td>{{ $profile->town or 'Not Saved' }}</td>
                  
              </tr>
              <tr>
                  <td><strong>Comment</strong></td>
                  <td>{{ $profile->comment or 'Not Saved' }}</td>
                  
              </tr>
              <tr>
                  <td><strong>Tax Card</strong></td>
                  <td>{{ $profile->tax_card or 'Not Saved' }}</td>
                  
              </tr>
          </tbody>
      </table>
 
  </div>


  </div>
@stop
