<?php

namespace App\Http\Tenant\Email\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class IncomingEmail extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_incoming_emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'user_id', 'msid', 'from_email', 'from_name', 'subject', 'body_html', 'body_text', 'is_seen', 'received_at', 'created_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $timestamps = false;




    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $dt = Carbon::Now();
            $model->created_at = $dt->format('Y-m-d H:i:s');

            return true;
        });


    }
}