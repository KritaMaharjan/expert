@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Lead Logs
@stop

@section('breadcrumb')
    @parent
    <li>Lead</li>
    <li>Logs</li>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Comment</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                    {!!Form::open(['class'=>'form-inline'])!!}
                    <div class="form-group col-xs-7 @if($errors->has('comment')) {{'has-error'}} @endif">
                        {!!Form::label(get_today_date()  ) !!}
                        {!!Form::text('comment', null, array('class' => 'form-control', 'placeholder' => 'Comment', 'style' => 'width: 80%;'))!!}
                        @if($errors->has('comment'))
                            {!! $errors->first('comment', '<label class="control-label"
                                                                               for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                    <div class="form-group col-xs-3">
                        {!!Form::label('Email:  ') !!}
                        {!!Form::select('emailed_to', $users, null, array('class' => 'form-control', 'id'
                        => 'email-select', 'style' => 'width: 80%;'))!!}
                    </div>
                    <div class="form-group col-xs-1">
                        {!!Form::submit('Add Comment', ['class' => 'btn btn-success'])!!}
                    </div>
                    {!!Form::close()!!}
                    </div>
                </div>
            </div>


            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Log List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <table id="table-lead-logs" class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Comments</th>
                                <th>Emailed</th>
                                <th>Added By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($logs->leadlogs as $leadlog)
                                <tr>
                                    <td>{{ format_datetime($leadlog->created_at) }}</td>
                                    <td>{{ $leadlog->log->comment }}</td>
                                    <td>{!! ($leadlog->log->email == null || $leadlog->log->email == 0)? '<span
                                                class="label label-danger">No</span>':'<span
                                                class="label label-success">Yes</span>' !!}
                                    </td>
                                    <td>{{ get_user_name($leadlog->log->added_by) }}</td>
                                    <td><a href="{{ route('system.lead.log.delete', [$leadlog->log->id]) }}" class="delete-log">Delete</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <!-- /.box -->
        </div>
    </div>
    {{EX::js('assets/js/lead/log.js')}}
@stop