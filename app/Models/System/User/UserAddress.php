<?php
namespace App\Models\System\User;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model {

    protected $table = 'user_address';
    protected $fillable = ['ex_users_id', 'address_id', 'address_type_id', 'is_current'];
    public $timestamps = false;

    /**
     * Get the address record associated.
     */
    public function address()
    {
        return $this->belongsTo('App\Models\System\Profile\Addresses', 'address_id');
    }
}