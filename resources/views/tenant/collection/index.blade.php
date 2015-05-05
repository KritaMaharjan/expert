@extends('tenant.layouts.main')

@section('heading')
Collections
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-header">
              <a class="btn  btn-primary btn-flat" href="{{url('collection')}}">All Collection Cases</a>
              <a class="btn  btn-default btn-flat" href="{{url('collection/waiting')}}">Waiting Update</a>
              <a class="btn  btn-default btn-flat pull-right" href="{{url('collection/new-case')}}">Add New Case</a>
        </div>

        <div class="box-header">
            <ol class="breadcrumb">
                <li class="active">Purring</li>
                <li><a href="{{tenant()->url('/collection?step=inkassovarsel')}}">Inkassovarsel</a></li>
                <li><a href="{{tenant()->url('/collection?step=betalingsappfording')}}">Betalingsappfording</a></li>
                <li><a href="{{tenant()->url('/collection?step=court-case')}}">Court Case</a></li>
                <li><a href="{{tenant()->url('/collection?step=utlegg')}}">Utlegg</a></li>
            </ol>
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
                     </tr>
                 </thead>
             <tbody></tbody>
           </table>
         </div><!-- /.box-body -->

    </div>


{{--Load JS--}}
{{FB::js('assets/js/collection/main.js')}}

@stop