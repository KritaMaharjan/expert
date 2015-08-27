<h3>Other Assets Details</h3>
<hr/>

@foreach($car_details as $key => $car_detail)
    <div class="review-box">
        <h4>Car {{$key + 1}}</h4>
        <table class="table table-striped table-hover">
            <tr>
                <td class="col-md-4">Ownership</td>
                <td class="col-md-6 applicant-content">{{get_applicant_name($car_detail->applicant_id)}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Make and Model</td>
                <td class="col-md-6 applicant-content">{{$car_detail->make_model}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Year Built</td>
                <td class="col-md-6 applicant-content">{{$car_detail->year_built}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Value</td>
                <td class="col-md-6 applicant-content">{{$car_detail->value}}</td>
            </tr>
        </table>
    </div>
@endforeach

@foreach($bank_details as $key => $bank_detail)
    <div class="review-box">
        <h4>Bank Account {{$key + 1}}</h4>
        <table class="table table-striped table-hover">
            <tr>
                <td class="col-md-4">Ownership</td>
                <td class="col-md-6 applicant-content">{{get_applicant_name($bank_detail->applicant_id)}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Bank Name</td>
                <td class="col-md-6 applicant-content">{{$bank_detail->bank}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Balance</td>
                <td class="col-md-6 applicant-content">{{$bank_detail->balance}}</td>
            </tr>
        </table>
    </div>
@endforeach

@foreach($other_details as $key => $other_detail)
    <div class="review-box">
        <h4>Other Asset {{$key + 1}}</h4>
        <table class="table table-striped table-hover">
            <tr>
                <td class="col-md-4">Ownership</td>
                <td class="col-md-6 applicant-content">{{get_applicant_name($other_detail->applicant_id)}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Type</td>
                <td class="col-md-6 applicant-content">{{$other_detail->type}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Value</td>
                <td class="col-md-6 applicant-content">{{$other_detail->value}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Home Content</td>
                <td class="col-md-6 applicant-content">{{$other_detail->home_content}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Superannuation</td>
                <td class="col-md-6 applicant-content">{{$other_detail->superannuation}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Deposit Paid</td>
                <td class="col-md-6 applicant-content">{{$other_detail->deposit_paid}}</td>
            </tr>
        </table>
    </div>
@endforeach

@foreach($card_details as $key => $card_detail)
    <div class="review-box">
        <h4>Credit Card {{$key + 1}}</h4>
        <table class="table table-striped table-hover">
            <tr>
                <td class="col-md-4">Ownership</td>
                <td class="col-md-6 applicant-content">{{get_applicant_name($card_detail->applicant_id)}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Credit Card Type</td>
                <td class="col-md-6 applicant-content">{{$card_detail->type}}</td>
            </tr>
            <tr>
                <td class="col-md-4">To Be Cleared</td>
                <td class="col-md-6 applicant-content">{{($card_detail->to_be_cleared == 1)? 'Yes' : 'No'}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Lender</td>
                <td class="col-md-6 applicant-content">{{$card_detail->lender}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Debit From</td>
                <td class="col-md-6 applicant-content">{{$card_detail->debit_from}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Limit</td>
                <td class="col-md-6 applicant-content">{{$card_detail->limit}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Balance</td>
                <td class="col-md-6 applicant-content">{{$card_detail->balance}}</td>
            </tr>
        </table>
    </div>
@endforeach

@foreach($other_income_details as $key => $other_income_detail)
    <div class="review-box">
        <h4>Other Income {{$key + 1}}</h4>
        <table class="table table-striped table-hover">
            <tr>
                <td class="col-md-4">Ownership</td>
                <td class="col-md-6 applicant-content">{{get_applicant_name($other_income_detail->applicant_id)}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Type</td>
                <td class="col-md-6 applicant-content">{{$other_income_detail->type}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Credit To</td>
                <td class="col-md-6 applicant-content">{{$other_income_detail->credit_to}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Monthly Net Income</td>
                <td class="col-md-6 applicant-content">{{$other_income_detail->monthly_net_income}}</td>
            </tr>
        </table>
    </div>
@endforeach