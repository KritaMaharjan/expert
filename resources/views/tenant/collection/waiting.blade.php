@extends('tenant.layouts.main')

@section('heading')
Collections
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-header">
              <a class="btn btn-primary btn-flat" href="{{url('collection/waiting')}}">Waiting Update</a>
              <a class="btn btn-default btn-flat" href="{{url('collection')}}">All Collection Cases</a>
              <a class="btn btn-default btn-flat pull-right" href="#" title="Add New Case" data-original-title="View" data-toggle="modal" data-url="{{ tenant()->url('collection/case/create') }}" data-target="#fb-modal">Add New Case</a>
        </div>

        <div class="box-body table-responsive">
           <table id="table-collection" class="table table-hover">
                 <thead>
                     <tr>
                       <th>Bill ID</th>
                       <th>Invoice Number</th>
                       <th>Customer</th>
                       <th>Total</th>
                       <th>Paid</th>
                       <th>Remaining</th>
                       <th>Due Date</th>
                       <th>Action</th>
                     </tr>
                 </thead>
             <tbody></tbody>
           </table>
         </div><!-- /.box-body -->
    </div>


{{--Load JS--}}
{{ FB::registerModal() }}
{{ FB::js('assets/js/collection/waiting.js') }}

@stop