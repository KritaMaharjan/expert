@extends('tenant.layouts.main')

@section('heading')
Collections
@stop

@section('breadcrumb')
    @parent
    <li>Collections</li>
@stop

@section('content')

@include('flash::message')

    <div class="box box-solid">
        <div class="box-header">
              <a class="btn btn-default btn-flat" href="{{url('collection/waiting')}}">Waiting Update</a>
              <a class="btn btn-primary btn-flat" href="{{url('collection')}}">All Collection Cases</a>
              <a class="btn btn-default btn-flat pull-right" href="#" title="Add New Case" data-original-title="View" data-toggle="modal" data-url="{{ tenant()->url('collection/case/create') }}" data-target="#fb-modal">Add New Case</a>
        </div>

        <?php $step = Input::get('step', 'purring');?>

        <div class="box-header">
            <ol class="breadcrumb step-links clearfix">
                <li {{ $step == 'purring' ? 'class=active': '' }}><a href="{{tenant()->url('/collection?step=purring')}}">Purring</a></li>
                <li {{ $step == 'inkassovarsel' ? 'class=active': '' }}><a href="{{tenant()->url('/collection?step=inkassovarsel')}}">Inkassovarsel</a></li>
                <li {{ $step == 'betalingsoppfording' ? 'class=active': '' }}><a href="{{tenant()->url('/collection?step=betalingsoppfording')}}">Betalingsoppfording</a></li>
                <li {{ $step == 'court' ? 'class=active': '' }}><a href="{{tenant()->url('/collection?step=court')}}">Court Case</a></li>
                <li {{ $step == 'utlegg' ? 'class=active': '' }}><a href="{{tenant()->url('/collection?step=utlegg')}}">Utlegg</a></li>
            </ol>
        </div>

        <div class="box-body table-responsive">
           <table id="table-collection" class="table table-hover">
                 <thead>
                     <tr>
                       <th>Invoice Number</th>
                       <th>Customer</th>
                       <th>Bill Amount</th>
                       <th>Fee</th>
                       <th>Interest</th>
                       <th>Paid</th>
                       <th>Remaining</th>
                       <th>Due Date</th>
                       @if(!in_array($step, ['court', 'utlegg']))
                       <th> Next step in Days</th>
                       @endif
                     </tr>
                 </thead>
             <tbody></tbody>
           </table>
         </div><!-- /.box-body -->

    </div>


{{--Load JS--}}
{{ FB::registerModal() }}
{{FB::js('assets/js/collection/main.js')}}
<link href="{{tenant()->url('assets/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet"/>
{{FB::js('assets/plugins/timepicker/bootstrap-timepicker.min.js')}}

@stop