<?php namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Setting;
use Illuminate\Http\Request;
use Response;


class SettingController extends BaseController {

    protected $setting;

    function __construct(Setting $setting)
    {
        \FB::can('Settings');
        $this->setting = $setting;
    }

    /* Show Email setting page
     *
     * @return response.view
     */
   function getSetting(){
    
   }
}
