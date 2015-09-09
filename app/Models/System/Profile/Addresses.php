<?php
namespace App\Models\System\Profile;

use Illuminate\Database\Eloquent\Model;

class Addresses extends Model {

    protected $table = 'addresses';
    protected $fillable = ['line1', 'line2', 'suburb', 'state', 'postcode', 'country'];
    public $timestamps = false;

    /**
     * Get the client address record associated.
     */
    public function clientaddress()
    {
        return $this->hasOne('App\Models\System\Client\ClientAddress', 'address_id');
    }
}