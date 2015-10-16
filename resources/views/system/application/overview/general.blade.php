<div class="box-body">

    <div class="box-header">
        <h3 class="box-title">Application Detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover table-striped">
            <tbody>
            <col width="30%">
            <col width="70%">
            <tr>
                <th>Application ID</th>
                <td>{{$application_details->id }}</td>
            </tr>
            <tr>
                <th>Date Created</th>
                <td>{{readable_date($application_details->date_created)}}</td>
            </tr>
            <tr>
                <th>Created By User</th>
                <td>{{get_user_name($application_details->ex_user_id)}}</td>
            </tr>
            <tr>
                <th>Client Name</th>
                <td>{{get_client_name($application_details->lead->ex_clients_id)}}</td>
            </tr>
            <tr>
                <th>Application Status</th>
                <td>{{($application_details->submitted == 1)? 'Submitted' : 'Not Submitted' }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>