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
                </tr>
                </thead>
                <tbody>
                @foreach($application_details->logs as $app_log)
                    <tr>
                        <td>{{ format_datetime($app_log->created_at) }}</td>
                        <td>{{ $app_log->log->comment }}</td>
                        <td>{!! ($app_log->log->email == null || $app_log->log->email == 0)? '<span
                                                class="label label-danger">No</span>':'<span
                                                class="label label-success">Yes</span>' !!}
                        </td>
                        <td>{{ get_user_name($app_log->log->added_by) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
<!-- /.box-body -->

<!-- /.box -->
