<?php
namespace App\Models\System\Client;

use Illuminate\Database\Eloquent\Model;

class ClientPhone extends Model {

    protected $table = 'client_phone';
    protected $fillable = ['phones_id', 'is_current', 'ex_clients_id'];

    public $timestamps = false;

    /**
     * Get the phone record associated.
     */
    public function phone()
    {
        return $this->belongsTo('App\Models\System\Profile\Phone', 'phones_id');
    }
}