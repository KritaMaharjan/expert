<?php
namespace App\Models\System\User;

use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model {

    protected $table = 'user_phone';
    protected $fillable = ['phones_id', 'is_current', 'ex_users_id'];

    public $timestamps = false;

    /**
     * Get the phone record associated.
     */
    public function phone()
    {
        return $this->belongsTo('App\Models\System\Profile\Phone', 'phones_id');
    }
}
