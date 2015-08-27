<?php
namespace App\Models\System\Property;

use Illuminate\Database\Eloquent\Model;

class ValuationAccess extends Model
{

    protected $table = 'valuation_access';
    protected $fillable = ['access_party', 'contact_person', 'phone_number', 'phone_number', 'property_id'];

    public $timestamps = false;

} 