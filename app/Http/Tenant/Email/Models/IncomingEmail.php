<?php

namespace App\Http\Tenant\Email\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant\Profile;

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
    protected $fillable = ['id', 'user_id', 'msid', 'from_email', 'from_name', 'subject', 'body_html', 'body_text', 'is_seen', 'type', 'received_at', 'created_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public $timestamps = false;

    function scopeUser($query)
    {
        $query->where('user_id', current_user()->id);
    }

    function scopeType($query, $type = 0)
    {
        $query->where('type', $type);
    }

    function saveEmail($mails, $type = 0)
    {
        foreach ($mails as $mail) {
            $exists = IncomingEmail::select('msid')->where('msid', 600)->where('user_id', current_user()->id)->exists();
            if(!$exists) {
                IncomingEmail::create([
                    'msid' => $mail->msid,
                    'user_id' => current_user()->id,
                    'from_email' => $mail->fromEmail,
                    'attachments' => NULL,
                    'from_name' => $mail->fromName,
                    'subject' => $mail->subject,
                    'body_html' => $mail->body,
                    'body_text' => $mail->body_text,
                    'is_seen' => $mail->isSeen,
                    'type' => $type,
                    'received_at' => $mail->receivedDate
                ]);
            }
        }

        $profile = Profile::where('user_id', current_user()->id)->first();
        $profile->email_sync_at = Carbon::now();
        $profile->save();
    }

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