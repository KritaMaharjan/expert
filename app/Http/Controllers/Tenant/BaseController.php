<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Tenant\Accounting\Models\AccountingYear;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Models\Tenant\Setting;

use Illuminate\Support\Facades\Auth;

/**
 * Class BaseController
 * @property mixed current_lang
 * @package App\Http\Controllers\Tenant
 */
class BaseController extends Controller {


    /**
     * Store Current logged in user info
     * @var
     */
    protected $current_user;

    /**
     * Store Current app language
     * @var
     */
    protected $current_lang;

    /**
     * Current Accounting Year
     * @var
     */
    protected $current_accounting_year = null;

    /**
     * initialized everything for Tenant Controllers
     */
    function __construct()
    {
        //init Language
        $this->initLang();

        // initialise current user
        $this->current_user();

        //check current user's status
        $this->authenticate_user();

        // share current route in all views
        $this->viewShare();
    }


    /**
     * Current logged in user info
     * @return null
     */
    function current_user()
    {
        if (Auth::check()) {
            return $this->current_user = Auth::user();
        } else {
            return $this->current_user = null;
        }
    }

    /**
     * Current logged in user status info
     * @return null
     */
    function authenticate_user()
    {
        if ($this->current_user) {
            if ($this->current_user->status == 0) {
                Auth::logout();
                flash(lang('Your account has not been activated.'));
                force_redirect(tenant()->url('login'));
            } elseif ($this->current_user->status == 2) {
                Auth::logout();
                flash(lang('Your account has been suspended.'));
                force_redirect(tenant()->url('login'));
            } elseif ($this->current_user->status == 3) {
                Auth::logout();
                flash(lang('Your account has been permanently blocked.'));
                force_redirect(tenant()->url('login'));
            }
        }
    }

    /**
     * Share variables to Views
     */
    function viewShare()
    {
        View::share('current_user', $this->current_user);
        View::share('current_route', Route::current()->getPath());
        View::share('current_path', Request::path());
        View::share('domain', session()->get('domain'));
        View::share('current_lang', $this->current_lang);
        View::share('current_accounting_year', $this->accountingYear());

        /* View::composer('tenant.layouts.partials.header', function ($view) {
             $view->with('company_logo', $this->getCompanyLogo());
         });*/
    }

    /**
     * get Current Accounting Year
     * @return bool|null
     */
    function accountingYear()
    {
        if (is_null($this->current_accounting_year))
            $this->current_accounting_year = AccountingYear::CurrentYear();

        return $this->current_accounting_year;
    }

    /**
     * Get Company logo
     * @return string
     */
    function getCompanyLogo()
    {
        $company_details = Setting::where('name', 'fix')->first();

        if (isset($company_details->value) AND isset($company_details['logo']))
            return asset('assets/uploads/' . $company_details['logo']);
        else
            return asset('assets/images/logo.png');
    }

    /**
     * return success json data to view
     * @param array $data
     * @return mixed
     */
    function success(array $data = array())
    {
        $response = ['status' => 1, 'data' => $data];

        return Response::json($response);
    }


    /**
     * return failed json data to view
     * @param array $data
     * @return mixed
     */
    function fail(array $data = array())
    {
        $response = ['status' => 0, 'data' => $data];

        return Response::json($response);
    }

    /**
     * Initialized Language for the app
     */
    function initLang()
    {
        $lang = Input::get('lang');

        if (is_null($lang)) {
            $lang = $this->getLang();
        }

        if ($this->isValidLang($lang)) {
            $this->setLang($lang);
        }

        $this->current_lang = $this->getLang();
    }

    /**
     * set app default language
     * @param string $lang
     */
    function setLang($lang = 'en')
    {
        \App::setLocale($lang);
        \Session::put('app_lang', $lang);
    }

    /**
     * set get app language
     * @return mixed
     */
    function getLang()
    {
        $lang = session()->get('app_lang');

        return $lang ? $lang : 'en';
    }


    function isValidLang($lang = '')
    {
        $available_lang = ['en', 'no'];
        if (in_array($lang, $available_lang)) {
            return true;
        }

        return false;
    }


}
