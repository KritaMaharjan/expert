<?php

namespace App\Fastbooks\Libraries;


use App\Models\Tenant\Setting;
use Illuminate\Contracts\Auth\Guard;

class SetupChecker {

    protected $auth;
    protected $setting;
    protected $route;

    function __construct(Guard $auth, Setting $setting)
    {
        $this->auth = $auth;
        $this->setting = $setting;
    }

    function isFirstCompleted()
    {
        $company = $this->setting->getCompany();
        $user = $this->auth->user();
        if (empty($company) || $user->password == '')
            return false;
        else
            return true;
    }

    function isSecondCompleted()
    {
        $business = $this->setting->getBusiness();
        if (empty($business))
            return false;
        else
            return true;
    }

    function isThirdCompleted()
    {
        $fix = $this->setting->getFix();
        if (empty($fix))
            return false;
        else
            return true;
    }

    function isSetupComplete()
    {
        if ($this->isFirstCompleted() == false) {
            $this->route = "tenant.setup.about";

            return false;
        }

        if ($this->isSecondCompleted() == false) {
            $this->route = "tenant.setup.business";

            return false;
        }

        return true;
    }

    function redirectRoute()
    {
        return tenant()->route($this->route);
    }

} 