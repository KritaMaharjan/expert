<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fb_profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['user_id', 'smtp', 'social_security_number', 'phone', 'address', 'postcode', 'town', 'comment', 'tax_card', 'vacation_fund_percentage', 'photo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $primaryKey = "user_id";


    public function updateprofile($user_id, $details, $flieds)
    {
        $profile = Profile::firstorNew(['user_id' => $user_id]);
        $profile->$flieds = $details;
        $profile->save();

    }

    function getSmtpAttribute($value)
    {
        $data = @unserialize($value);
        if ($data !== false) {
            return $data;
        } else {
            return $value;
        }
    }

    public function getPersonalSetting($user_id = '')
    {
        $profile = Profile::firstOrCreate(['user_id' => $user_id]);
        $data = @unserialize($profile->smtp);
        if ($data !== false) {
            return $data;
        } else {
            return $profile->smtp;
        }
    }



}
