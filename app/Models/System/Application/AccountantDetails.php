<?php
namespace App\Models\System\Application;

use App\Models\System\Profile\Addresses;
use Illuminate\Database\Eloquent\Model;

class AccountantDetails extends Model {

    protected $table = 'accountant_details';
    protected $fillable = ['accountant_business_name', 'contact_person', 'phone_number', 'business_address_id', 'employment_details_id'];

    public $timestamps = false;

    public function add($employment_id, $request, $key)
    {
        $business_address = Addresses::create([
            'line1' => $request['accountant_line1'][$key],
            'line2' => $request['accountant_line2'][$key],
            'suburb' => $request['accountant_suburb'][$key],
            'state' => $request['accountant_state'][$key],
            'postcode' => $request['accountant_postcode'][$key],
            'country' => $request['accountant_country'][$key]
        ]);

        AccountantDetails::create([
            'accountant_business_name' => $request['accountant_business_name'][$key],
            'contact_person' => $request['accountant_contact_person'][$key],
            'phone_number' => $request['accountant_phone_number'][$key],
            'business_address_id' => $business_address->id,
            'employment_details_id' => $employment_id
        ]);
    }

}