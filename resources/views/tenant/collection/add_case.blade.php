@extends('tenant.layouts.main')

@section('heading')
Add New Case
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-header">
              <a class="btn  btn-default btn-flat" href="{{url('collection')}}">All Collection Cases</a>
              <a class="btn  btn-default btn-flat" href="{{url('collection/waiting')}}">Waiting Update</a>
              <a class="btn  btn-default btn-flat pull-right" href="{{url('collection/new-case')}}">Add New Case</a>

        </div>

        <div class="box-body table-responsive">


         </div><!-- /.box-body -->

    </div>



@stop