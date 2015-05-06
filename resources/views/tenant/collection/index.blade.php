@extends('tenant.layouts.main')

@section('heading')
Collections
@stop

@section('content')

@include('flash::message')

    <div class="box box-solid">
        <div class="box-header">
              <a class="btn  btn-primary btn-flat" href="{{url('collection')}}">All Collection Cases</a>
              <a class="btn  btn-default btn-flat" href="{{url('collection/waiting')}}">Waiting Update</a>
              <a class="btn  btn-default btn-flat pull-right" href="{{url('collection/new-case')}}">Add New Case</a>
        </div>

        <?php $step = Input::get('step', 'purring');?>

        <div class="box-header">
            <ol class="breadcrumb">
                <li {{ $step == 'purring' ? 'class="active"': '' }}><a href="{{tenant()->url('/collection?step=purring')}}">Purring</a></li>
                <li {{ $step == 'inkassovarsel' ? 'class="active"': '' }}><a href="{{tenant()->url('/collection?step=inkassovarsel')}}">Inkassovarsel</a></li>
                <li {{ $step == 'betalingsappfording' ? 'class="active"': '' }}><a href="{{tenant()->url('/collection?step=betalingsappfording')}}">Betalingsappfording</a></li>
                <li {{ $step == 'court' ? 'class="active"': '' }}><a href="{{tenant()->url('/collection?step=court')}}">Court Case</a></li>
                <li {{ $step == 'utlegg' ? 'class="active"': '' }}><a href="{{tenant()->url('/collection?step=utlegg')}}">Utlegg</a></li>
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
                       <th>Invoice Date</th>
                     </tr>
                 </thead>
             <tbody></tbody>
           </table>
         </div><!-- /.box-body -->

    </div>


{{--Load JS--}}
{{FB::js('assets/js/collection/main.js')}}

@stop