<div class="box-body">

    <div class="box-header">
        <h3 class="box-title">Lead Detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover table-striped">
            <tbody>
            <col width="30%">
            <col width="70%">
            <tr>
                <th>Lead ID</th>
                <td>{{$application_details->lead->id }}</td>
            </tr>
            <tr>
                <th>Referral Notes</th>
                <td>{{$application_details->lead->referral_notes}}</td>
            </tr>
            <tr>
                <th>Feedback</th>
                <td>{{get_user_name($application_details->lead->feedback)}}</td>
            </tr>
            <tr>
                <th>Feedback</th>
                <td>{{get_user_name($application_details->lead->feedback)}}</td>
            </tr>
            <tr>
                <th>Property Search Area</th>
                <td>{{$application_details->lead->property_search_area}}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{($application_details->lead->status == 1)? 'Assigned' : 'Unassigned' }}</td>
            </tr>
            <tr>
                <th>Created Date</th>
                <td>{{format_datetime($application_details->lead->created_at)}}</td>
            </tr>
            <tr>
                <th>Created By</th>
                <td>{{get_user_name($application_details->lead->added_by_users_id)}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>