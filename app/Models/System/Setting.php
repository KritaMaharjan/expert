<?php namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

    protected $table = "settings";

    protected $connection = "master";

    protected $primaryKey = "name";

  
    function scopeEmail($query)
    {
        return $query->where('name', 'email');
    }

    function scopeTemplate($query)
    {
        return $query->where('name', 'template');
    }

    function get_template(){
         $setting = $this->template()->first();
         if(!empty($setting))
            return (object)$setting->value;
        else
            return false;
        
    }

    function get_email(){
        $setting = $this->email()->first();
       if(!empty($setting))
            return (object)$setting->value;
        else
            return false;
    }


    function addOrUpdate(array $data = array(), $group = 'autoload')
    {
        if (!empty($data)):
            foreach ($data as $key => $value) {
                $setting = Setting::firstOrNew(['name' => $key]);
                if (is_array($value) || is_object($value)) {
                    $setting->value = serialize($value);
                } else {
                    $setting->value = $value;
                }
                $setting->autoload = $group;
                $setting->save();
            }
        endif;
    }

    function getValueAttribute($value)
    {
        $data = @unserialize($value);
        if ($data !== false) {
            return $data;
        } else {
            return $value;
        }
    }

}
