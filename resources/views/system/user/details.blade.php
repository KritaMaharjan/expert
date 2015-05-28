@extends('system.layouts.main')
@section('title')
Client 
@stop
@section('heading')
Client
@stop

@section('breadcrumb')
    @parent
    <li><a href="{{url('system/client')}}"> Clients</a></li>
    <li>{{$tenant->basic->username}}</li>
@stop

@section('content')

    <div class="box box-solid">
        <div class="box-body">

          
                                <div class="box-header">
                                    <h3 class="box-title">Client Detail</h3>
                                    <div class="box-tools">
                                        
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tbody>
                                      
                                         <tr>
                                            <td>Email</td>
                                            <td>{{$tenant->basic->email or ''}}</td>
                                            
                                         </tr>

                                         <tr>
                                            <td>Business Name</td>
                                             <td>{{$tenant->basic->company or ''}}</td>
                                            
                                         </tr>

                                         <tr>
                                            <td>Business Number</td>
                                            <td>{{$tenant->company['company_number'] or ''}}</td>
                                            
                                        </tr>

                                         <tr>
                                            <td>Address</td>
                                            <td>{{$tenant->business['address'] or ''}}</td>
                                            
                                        </tr>

                                         <tr>
                                            <td>Postal Code</td>
                                            <td>{{$tenant->business['postal_code']  or ''}}</td>
                                            
                                        </tr>

                                        <tr>
                                            <td>Postal Town</td>
                                            <td>{{$tenant->business['town'] or ''}}</td>
                                            
                                        </tr>
                                        
                                         <tr>
                                            <td>Status</td>
                                            <td>@if($tenant->basic->status == 1) Active @elseif($tenant->basic->status == 0) Inactive @endif</td>
                                            
                                        </tr>

                                          <tr>
                                                <td>URL</td>
                                                <td><a target="_blank" href="http://{{$tenant->basic->domain}}.{{env('APP_DOMAIN')}}">{{$tenant->basic->domain}}.{{env('APP_DOMAIN')}}</a></td>

                                            </tr>
                                        <tr>
                                            <td>Signup Date</td>
                                            <td>{{$tenant->basic->created_at or ''}}</td>
                                            
                                        </tr>

                                         <tr>
                                            <td>Total Customer</td>
                                            <td>{{$tenant->customers or ''}}</td>
                                            
                                        </tr>
                                       

                                         <tr>
                                            <td>Total Bills</td>
                                            <td>{{$tenant->bill or ''}}</td>
                                            
                                        </tr>

                                         <tr>
                                            <td>Total users</td>
                                            <td>{{$tenant->users or ''}}</td>
                                            
                                        </tr>

                                         <tr>
                                            <td>Total inventory</td>
                                            <td>{{$tenant->inventory or ''}}</td>
                                            
                                        </tr>
                                    </tbody></table>
                               
                            </div>
                            <input class="btn btn-primary" Type="button" VALUE="Back" onClick="history.go(-1);return true;">
                           <a href="{{url('system/confirmDelete')}}/{{$tenant->basic->domain}}" onclick="return confirm_delete()">Confirm Delete</a>

        </div>

        <script type="text/javascript">
function confirm_delete() {
  return confirm('Are you sure to delete this tenant?');
}
</script>

@stop