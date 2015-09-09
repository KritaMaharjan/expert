<?php
namespace App\Models\System\Application;

use Illuminate\Database\Eloquent\Model;

class AccountantDetails extends Model {

    protected $table = 'accountant_details';
    protected $fillable = ['accountant_business_name', 'contact_person', 'phone_number', 'business_address_id', 'employment_details_id'];

    public $timestamps = false;

}