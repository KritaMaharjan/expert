<?php namespace App\Http\Controllers\System;

use App\Models\System\Setting;
use Illuminate\Http\Request;

class SettingController extends BaseController {

    protected $setting;

    function __construct(Setting $setting)
    {
        parent::__construct();
        $this->setting = $setting;
    }

    /* Show Email setting page
     *
     * @return response.view
     */
    function email()
    {
        $setting = $this->setting->get_email();
        return view('system.setting.email', compact('setting'));
    }


    /* Show Template setting page
    *
    * @return response.view
    */
    function template()
    {
        $setting = $this->setting->get_template();
        return view('system.setting.template' ,compact('setting'));
    }

    /* Update setting values
    * @return JSON
    */
    function update(Request $request)
    {
        $all = $request->except('_token', 'group');
        $group = $request->input('group');
        $validator = \Validator::make($request->all(),
                                        array(
                                            'name' => 'required',
                                            'email' => 'required|email',
                                            'password' => 'required',
                                            'notify' => 'required|email',
                                            )
                                        );

        if ($validator->fails()) {
           return  tenant()->route('system.setting.email')->withErrors($validator)->withInput();

        } 
        
        if ($group != '') {
            $this->setting->addOrUpdate([$group => $all], $group);
        } else {
            $this->setting->addOrUpdate($all);
        }

        return redirect()->back()->with('message', 'Setting Updated successfully');
    }

    function updateTemplate(Request $request)
    {
        $all = $request->except('_token', 'group');
        $group = $request->input('group');
        $validator = \Validator::make($request->all(),
            array(
                'confirmation_email_subject' => 'required|max:100',
                'confirmation_email' => 'required',
                'forgot_password_subject' => 'required|max:100',
                'forgot_password' => 'required',
                'password_confirm_subject' => 'required|max:100',
                'password_confirm' => 'required',
                'email_log_subject' => 'required|max:100',
                'email_log' => 'required'
            )
        );

        if ($validator->fails()) {
            return  redirect()->route('system.setting.template')->withErrors($validator)->withInput();
        }

        if ($group != '') {
            $this->setting->addOrUpdate([$group => $all], $group);
        } else {
            $this->setting->addOrUpdate($all);
        }

        return redirect()->back()->with('message', 'Template Updated successfully');
    }

}
