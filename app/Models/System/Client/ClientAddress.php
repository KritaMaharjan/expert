<?php
namespace App\Models\System\Client;

use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model {

    protected $table = 'client_address';
    protected $fillable = ['ex_clients_id', 'address_id', 'address_type_id', 'is_current'];
    public $timestamps = false;

    /**
     * Get the address record associated.
     */
    public function address()
    {
        return $this->belongsTo('App\Models\System\Profile\Addresses', 'address_id');
    }
}