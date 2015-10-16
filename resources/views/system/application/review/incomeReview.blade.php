<h3>
    Income Details
    <a class="pull-right" href="{{route('system.application.income', [$lead_id])}}"><i class="fa fa-pencil"></i></a>
</h3>
<hr/>

@foreach($income_details as $key => $income_detail)
    <div class="box box-linked collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Employment {{$key + 1}}</h3>

            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>

            </div>
        </div>
        <div class="box-body" style="display: none;">
            <div class="">
                <table class="table table-striped table-hover">
                    <tr>
                        <td colspan="2" class="col-md-10 title-sm">Income Details</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Ownership</td>
                        <td class="col-md-6 applicant-content">{{get_applicant_name($income_detail->applicant_id)}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Annual Gross Income</td>
                        <td class="col-md-6 applicant-content">{{$income_detail->annual_gross_income}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Pay Frequency</td>
                        <td class="col-md-6 applicant-content">{{$income_detail->pay_frequency}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Salary Crediting</td>
                        <td class="col-md-6 applicant-content">{{($income_detail->salary_crediting == 0)? 'No' : 'Yes'}}</td>
                    </tr>
                    @if($income_detail->salary_crediting == 1 && isset($income_detail->credit_to_where))
                        <tr>
                            <td class="col-md-4">Credits To</td>
                            <td class="col-md-6 applicant-content">{{$income_detail->credit_to_where}}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="col-md-4">Latest Pay Date</td>
                        <td class="col-md-6 applicant-content">{{readable_date($income_detail->latest_pay_date)}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Latest Payslip Period From</td>
                        <td class="col-md-6 applicant-content">{{readable_date($income_detail->latest_payslip_period_from)}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Latest Payslip Period To</td>
                        <td class="col-md-6 applicant-content">{{readable_date($income_detail->latest_payslip_period_to)}}</td>
                    </tr>

                    <tr>
                        <td colspan="2" class="col-md-10 title-sm">Employment Details</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Employment Type</td>
                        <td class="col-md-6 applicant-content">{{$income_detail->employment_type}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Job Title</td>
                        <td class="col-md-6 applicant-content">{{$income_detail->job_title}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Starting Date</td>
                        <td class="col-md-6 applicant-content">{{readable_date($income_detail->starting_date)}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Employer Business Name</td>
                        <td class="col-md-6 applicant-content">{{$income_detail->business_name}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Employer ABN</td>
                        <td class="col-md-6 applicant-content">{{$income_detail->abn}}</td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
@endforeach