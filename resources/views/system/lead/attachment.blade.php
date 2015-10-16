@extends('system.layouts.main')

@section('heading')
    Interview Notes
@stop

@section('breadcrumb')
    @parent
    <li>Lead</li>
    <li>Upload Interview Notes</li>
@stop

@section('content')
    <div class="pad margin no-print">
        <div class="callout callout-info" style="margin-bottom: 0!important;">
            <h4><i class="fa fa-info"></i> Note:</h4>
            The supported mime types for the attachments are Word, TXT, PDF and Excel files.
        </div>
    </div>
    <div class="col-xs-12 mainContainer">
        @include('flash::message')

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Upload File</h3>
            </div>
            {!! Form::open(['files' => true, 'method' => 'post']) !!}
            <div class="box-body">
                @if(!empty($attachment))
                    <div class="box-body table-responsive">
                        <strong>Uploaded File</strong>
                        <table id="table-lead" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Uploaded On</th>
                                <th>Uploaded By</th>
                                <th>Filename</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{format_datetime($attachment->uploaded_date)}}</td>
                                <td>{{ get_user_name($attachment->added_by_users_id) }}</td>
                                <td>{{ $attachment->filename }}</td>
                                <td><a href="{{ url('/resources/uploads/attachments').'/'.$attachment->filename }}" target="_blank"><i class="fa fa-eye"></i> View</a>
                                    <a href="{{route('system.lead.downloadAttachment', $attachment->id)}}" target="_blank"><i class="fa fa-download"></i> Download</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {!! Form::file('attachment') !!}
            </div>
            <div class="box-footer">
                {!! Form::submit('Upload', ['class' => "btn btn-primary"]) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
