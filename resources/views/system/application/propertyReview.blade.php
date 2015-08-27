<h3>Property Details</h3>
<hr/>

@foreach($property_details as $key => $property_detail)
    <div class="review-box">
        <h4>Property {{$key + 1}}</h4>

        <table class="table table-striped table-hover">
            <tr>
                <td colspan="2" class="col-md-10 title-sm">General Details</td>
            </tr>
            <tr>
                <td class="col-md-4">Taken As Security</td>
                <td class="col-md-6 applicant-content">{{($property_detail->taken_as_security == 1)? 'Yes' : 'No'}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Market Value</td>
                <td class="col-md-6 applicant-content">{{$property_detail->market_value}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Ownership</td>
                <td class="col-md-6 applicant-content">{{get_applicant_name($property_detail->applicant_id)}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Property Usage</td>
                <td class="col-md-6 applicant-content">{{config('general.property_usage')[$property_detail->property_usage]}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Property Type</td>
                <td class="col-md-6 applicant-content">{{config('general.property_type')[$property_detail->property_type]}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Number of Bedrooms</td>
                <td class="col-md-6 applicant-content">{{$property_detail->number_of_bedrooms}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Number of Bathrooms</td>
                <td class="col-md-6 applicant-content">{{$property_detail->number_of_bathrooms}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Number of Car Spaces</td>
                <td class="col-md-6 applicant-content">{{$property_detail->number_of_car_spaces}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Size</td>
                <td class="col-md-6 applicant-content">{{$property_detail->size}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Title Particulars</td>
                <td class="col-md-6 applicant-content">{{$property_detail->title_particulars}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Title Type</td>
                <td class="col-md-6 applicant-content">{{$property_detail->title_type}}</td>
            </tr>

            <tr>
                <td colspan="2" class="col-md-10 title-sm">Address Details</td>
            </tr>
            <tr>
                <td class="col-md-4">Line 1</td>
                <td class="col-md-6 applicant-content">{{$property_detail->line1}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Line 2</td>
                <td class="col-md-6 applicant-content">{{$property_detail->line2}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Suburb</td>
                <td class="col-md-6 applicant-content">{{$property_detail->suburb}}</td>
            </tr>
            <tr>
                <td class="col-md-4">State</td>
                <td class="col-md-6 applicant-content">{{$property_detail->state}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Postcode</td>
                <td class="col-md-6 applicant-content">{{$property_detail->postcode}}</td>
            </tr>
            <tr>
                <td class="col-md-4">Country</td>
                <td class="col-md-6 applicant-content">{{$property_detail->country}}</td>
            </tr>
        </table>
    </div>
@endforeach