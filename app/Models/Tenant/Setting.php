<?php
namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

    protected $table = "fb_settings";

    protected $fillable = ['name', 'value'];

    protected $primaryKey = "name";

    protected $connection = 'tenant';


    function get($name)
    {
        return $this->where('name', $name)->first();
    }

    function scopeFix($query)
    {
        return $query->where('name', 'fix');
    }

    function scopeCompany($query)
    {
        return $query->where('name', 'company');
    }

    function scopeSetting($query)
    {
        return $query->where('name', 'userSetting');
    }

    function scopeBusiness($query)
    {
        return $query->where('name', 'business');
    }

    function scopeVacation($query)
    {
        return $query->where('name', 'vacation');
    }

    function getCompany()
    {
        $company = $this->company()->first(['value']);

        return isset($company->value) ? $company->value : null;
    }

    function getSetting()
    {
        $setting = $this->setting()->first(['value']);

        return isset($setting->value) ? $setting->value : null;
    }

    function getvacation()
    {
        $vacation = $this->setting()->first(['value']);

        return isset($vacation->value) ? $vacation->value : null;
    }

    function getFix()
    {
        $fix = $this->fix()->first(['value']);

        return isset($fix->value) ? $fix->value : null;
    }

    function getBusiness()
    {
        $business = $this->business()->first(['value']);

        return isset($business->value) ? $business->value : null;
    }

    function saveSetup($name = '', $value = '')
    {
        $setup = Setting::firstOrNew(['name' => $name]);
        $setup->value = $value;
        $setup->save();
    }

    function addOrUpdate(array $data = array(),$group = NULL)
    {
        if (!empty($data)):
            if(is_null($group)){
                foreach ($data as $key => $value) {

                $setting = Setting::firstOrNew(['name' => $key]);
              
                    $setting->value = $value;
                
                $setting->save();
            }

            }else{
                foreach ($data as $key => $value) {

                $setting = Setting::firstOrNew(['name' => $group]);
                if (is_array($value) || is_object($value)) {
                    $setting->value = serialize($value);
                } else {
                    $setting->value = $value;
                }
                $setting->save();
            }

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
