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