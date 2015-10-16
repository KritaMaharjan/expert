<div class="box-body table-responsive">
    <strong>Application Steps</strong>


    <table id="table-lead" class="table table-hover">
        <thead>
        <tr>
            <th>Application Preparation</th>
            <th>Assigned to Admin</th>
            <th>Application Received</th>
            <th>Loan Submission</th>
            <th>System Approved</th>
            <th>Valuation</th>
            <th>Verification</th>
            <th>Loan Contract</th>
            <th>Discharge</th>
            <th>Settlement</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @foreach($statuses as $key => $status)
                <td>
                    {{ (isset($completed[$key]['date_created']))? $completed[$key]['date_created'] : '' }}
                </td>
            @endforeach
        </tr>
        <tr>
            @foreach($statuses as $key => $status)
                <td>
                    {{ (isset($completed[$key]['updated_by']))? $completed[$key]['updated_by'] : '' }}
                </td>
            @endforeach
        </tr>
        </tbody>
    </table>
    Change Status
    @foreach($statuses as $key => $status)
        @if(!isset($completed[$key]))
            <div class="checkbox icheck">
            <label>
                <input type="checkbox" name="status" class="status" value={{$key}}> {{$status}}
            </label>
        </div>
        @endif
    @endforeach
</div>

<script type="text/javascript">
    var application_id = "{{ $application_details->id }}";
</script>

{{EX::js('assets/js/application/status.js')}}