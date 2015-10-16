<h3>
    Loan Details
    <a class="pull-right" href="{{route('system.application.loan', [$lead_id])}}"><i class="fa fa-pencil"></i></a>
</h3>
<hr/>

@foreach($loan_details as $key => $loan_detail)
    <div class="box box-linked collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Loan {{$key + 1}} Details</h3>

            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>

            </div>
        </div>
        <div class="box-body" style="display: none;">
            <div class="">
                <table class="table table-striped table-hover">
                    <tr>
                        <td class="col-md-4">Loan Purpose</td>
                        <td class="col-md-6 applicant-content">
                            {{$loan_detail->loan_purpose}}</td>
                    </tr>

                    <tr>
                        <td class="col-md-4">Deposit Paid</td>
                        <td class="col-md-6 applicant-content">
                            {{$loan_detail->deposit_paid}}</td>
                    </tr>

                    <tr>
                        <td class="col-md-4">Settlement Date</td>
                        <td class="col-md-6 applicant-content">{{$loan_detail->settlement_date}}</td>
                    </tr>

                    <tr>
                        <td class="col-md-4">Loan Usage</td>
                        <td class="col-md-6 applicant-content">{{$loan_detail->loan_usage}}
                        </td>
                    </tr>

                    <tr>
                        <td class="col-md-4">Total loan term</td>
                        <td class="col-md-6 applicant-content">
                            {{$loan_detail->total_loan_term}}</td>
                    </tr>

                    <tr>
                        <td class="col-md-4">Loan Type</td>
                        <td class="col-md-6 applicant-content">
                            {{$loan_detail->loan_type}}
                        </td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Fixed Rate Terms</td>
                        <td class="col-md-6 applicant-content">
                            {{$loan_detail->fixed_rate_term}}</td>
                    </tr>

                    <tr>
                        <td class="col-md-4">Repayment Type</td>
                        <td class="col-md-6 applicant-content">
                            {{$loan_detail->repayment_type}}
                        </td>
                    </tr>

                    <tr>
                        <td class="col-md-4">IO Term</td>
                        <td class="col-md-6 applicant-content">
                            {{$loan_detail->io_term}}
                        </td>
                    </tr>

                    <tr>
                        <td class="col-md-4">Interest rate</td>
                        <td class="col-md-6 applicant-content">
                            {{$loan_detail->interest_rate}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endforeach