<h3>Income Details</h3>
<hr/>

@foreach($income_details_details as $key => $income_details_detail)
    <div class="review-box">
        <h4>Car {{$key + 1}}</h4>
        <table class="table table-striped table-hover">
            <tr>
                <td class="col-md-4">Ownership</td>
                <td class="col-md-6 applicant-content">{{get_applicant_name($income_details_detail->applicant_id)}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Annual Gross Income</td>
                <td class="col-md-6 applicant-content">{{$income_details_detail->annual_gross_income}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Pay Frequency</td>
                <td class="col-md-6 applicant-content">{{$income_details_detail->pay_frequency}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Value</td>
                <td class="col-md-6 applicant-content">{{$income_details_detail->value}}</td>
            </tr>
        </table>
    </div>
@endforeach