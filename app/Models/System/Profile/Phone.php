<?php
namespace App\Models\System\Profile;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model {

    protected $table = 'phones';
    protected $fillable = ['area_code', 'number', 'type'];

    public $timestamps = false;

    /**
     * Get the phone record associated.
     */
    public function phone()
    {
        return $this->hasOne('App\Models\System\Client\ClientPhone', 'phones_id');
    }
}