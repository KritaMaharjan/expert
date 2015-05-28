@extends('system.layouts.main')
@section('title')
Client
@stop
@section('heading')
Manage Client
@stop

@section('breadcrumb')
@parent
<li>Clients</li>
@stop

@section('content')
<div class="box box-solid">
    <div class="box-body">
        <div class="box box-solid">
                               <!--  <div class="box-header">
                                    <h3 class="box-title"></h3>
                                    <div class="box-tools">
                                        
                                    </div>
                                </div>/.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table id="table-client" class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th>ID</th>
                                            <th>Domain</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                          
                                            </tr>
                                        <thead>
                                        
                                        
                                </table>
                                </div><!-- /.box-body -->
                            </div>
     </div>
     <script type="text/javascript">
$(document).ready(function () {
 
    
});
</script>


{{--Load JS--}}
    {{FB::registerModal()}}
    {{FB::js('assets/js/system/client.js')}}
@stop

