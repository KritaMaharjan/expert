@extends('tenant.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
{{ ucfirst($type) }}
@stop

@section('breadcrumb')
    @parent
    <li>Invoice</li>
    <li>{{ ucfirst($type) }}</li>
@stop

@section('content')

<div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
          <div class="box box-solid">
            <p class="align-right btn-inside">
                 <a class="btn btn-primary" href="{{tenant_route('tenant.invoice.'.$type.'.add')}}">
                       <i class="fa fa-plus"></i> Add new {{ $type }}
                 </a>
             </p>
            <div class="box-body table-responsive">
              <table id="table-bill" class="table table-hover table-bill">
                <thead>
                    <tr>
                      <th>Invoice Number</th>
                      <th>Name of recipient</th>
                      <th>Total Amount</th>
                      <th>Remaining Amount</th>
                      <th>Invoice Date</th>
                      @if($type == 'bill') <th>Status</th> @endif
                      <th>Action</th>
                    </tr>
                </thead>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
</div>
    <script>
       var thisUrl = "{{ $type }}";
    </script>
    {{--Load JS--}}
    {{FB::registerModal()}}
    {{FB::js('assets/js/bill.js')}}

@stop