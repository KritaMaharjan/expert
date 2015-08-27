<h3>Applicant Details</h3>
<hr/>

@foreach($applicant_details as $key => $applicant_detail)
    <div class="review-box">
        <h4>Applicant {{$key + 1}}</h4>

        <div class="title-sm">Personal Details</div>
        <table class="table table-striped table-hover">
            <tr>
                <td class="col-md-4">Title</td>
                <td class="col-md-6 applicant-content">{{$applicant_detail->title}}</td>
            </tr>
            <tr>
                <td class="col-md-4">First Name</td>
                <td class="col-md-6 applicant-content">{{$applicant_detail->given_name}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Last Name</td>
                <td class="col-md-6 applicant-content">{{$applicant_detail->surname}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Mother's Maiden Name</td>
                <td class="col-md-6 applicant-content">{{$applicant_detail->mother_maiden_name}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Date Of Birth</td>
                <td class="col-md-6 applicant-content">{{readable_date($applicant_detail->dob)}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Residency Status</td>
                <td class="col-md-6 applicant-content">{{$applicant_detail->residency_status}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Years in AU</td>
                <td class="col-md-6 applicant-content">{{$applicant_detail->years_in_au}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Marital Status</td>
                <td class="col-md-6 applicant-content">{{$applicant_detail->marital_status}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Credit Card Issues</td>
                <td class="col-md-6 applicant-content">{{($applicant_detail->credit_card_issue == 1)? 'Yes' : 'No'}}</td>
            </tr>
            @if($applicant_detail->credit_card_issue == 1)
                <tr>
                    <td class="col-md-4">Issue Comments</td>
                    <td class="col-md-6 applicant-content">{{$applicant_detail->issue_comments}}</td>
                </tr>
            @endif
            <tr>
                <td class="col-md-4">Driver Licence Number</td>
                <td class="col-md-6 applicant-content">{{$applicant_detail->driver_licence_number}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Licence State</td>
                <td class="col-md-6 applicant-content">{{$applicant_detail->licence_state}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Licence Expiry Date</td>
                <td class="col-md-6 applicant-content">{{$applicant_detail->licence_expiry_date}}</td>
            </tr>

            @foreach($applicant_detail->address as $address)
                <tr>
                    <td colspan ="2" class="col-md-10 title-sm">{{($address->iscurrent == 0 && $address->type == 'Home')? 'Previous': $address->type}} Address</td>
                </tr>
                <tr>
                    <td class="col-md-4">Line 1</td>
                    <td class="col-md-6 applicant-content">{{$address->line1}}</td>
                </tr>
                <tr>
                    <td class="col-md-4">Line 2</td>
                    <td class="col-md-6 applicant-content">{{$address->line2}}</td>
                </tr>
                <tr>
                    <td class="col-md-4">Suburb</td>
                    <td class="col-md-6 applicant-content">{{$address->suburb}}</td>
                </tr>
                <tr>
                    <td class="col-md-4">State</td>
                    <td class="col-md-6 applicant-content">{{$address->state}}</td>
                </tr>
                <tr>
                    <td class="col-md-4">Postcode</td>
                    <td class="col-md-6 applicant-content">{{$address->postcode}}</td>
                </tr>
                <tr>
                    <td class="col-md-4">Country</td>
                    <td class="col-md-6 applicant-content">{{$address->country}}</td>
                </tr>
                @if($address->type == 'Home' && $address->iscurrent == 1)
                    <tr>
                        <td class="col-md-4">Living There Since</td>
                        <td class="col-md-6 applicant-content">{{$address->live_there_since}}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
@endforeach