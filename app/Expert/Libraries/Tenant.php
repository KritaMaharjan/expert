<?php
namespace App\Expert\Libraries;

use App;
use DB;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use App\Fastbooks\Libraries\TenantTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;

/**
 * Class Tenant
 * @package App\Fastbooks\Libraries
 */
class Tenant {



    /**
     * @param Request $request
     * @param User $user
     * @param TenantTable $TenantTable
     * @param Guard $auth
     */
    function __construct(Request $request, User $user, Guard $auth)
    {
        $this->init();
        $this->tenatUser = $user;
        $this->auth = $auth;
        $this->request = $request;
    }

    function createFolders()
    {
        $this->folder('customer', true);
        $this->folder('attachment', true);
        $this->folder('invoice', true);
        $this->folder('user', true);
        $this->folder('temp', true);
        $this->folder('expense', true);
        $this->folder('todo', true);
    }

    /**
     * Get name of a tenant
     * @return string
     */
    function getName()
    {
        return $this->domain;
    }


    function setDomain($domain = '')
    {
        $this->domain = $domain;
        session()->put('domain', $this->domain);
    }

    /**
     * check for valid subdomain
     * @return bool
     */
    function isValidSubDomain()
    {
        // check for register tenant
        $tenant = $this->getTenantinfo();
        if (empty($tenant)) {
            show_404();
        }
        //check tenant is allow to access app
        $tenant->actionWithStatus();

        return true;
    }

    /**
     * Get detail of admin of tenant app
     * @return mixed
     */
    function getTenantinfo()
    {
        $user = SystemTenant::where('domain', $this->domain)->first();

        return $user;
    }

    /**
     * Extract sub-domain from site url
     * @return string
     */
    function getSubdomain()
    {

        if (env('APP_ENV') == 'local') {
            // It will work for local environment for live need to change code
            $path = explode('/', $this->request->path());
            $domain = trim($path[0]);

            if ($domain) {
                return $domain;
            }
            show_404();
        }

        $current_params = \Route::current()->parameters();
        if (isset($current_params['account']) AND $current_params['account'] != '') {
            return $current_params['account'];
        }

        return null;
    }

    /**
     * Check for first time loginto tenant app
     * @return bool
     * @todo session is not working between sudomain and domain so we are not using this function
     */
    function _isFirstTime()
    {
        $data = session()->get('register_tenant');
        if (!is_null($data)) {
            return $data['first_time'];
        }

        return false;
    }


    /**
     * @return bool
     */
    function isFirstTime()
    {
        $setupKey = $this->request->input('setup');
        // verify key to setup an account
        if (strlen($setupKey) > 10) {
            $tenant = SystemTenant::where('setup_key', $setupKey)->where('domain', $this->domain)->count();
            if ($tenant > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Reset Setup
     */
    function resetSetup()
    {
        $tenantInfoInSystem = $this->getTenantinfo();
        $tenantInfoInSystem->setup_key = null;
        $tenantInfoInSystem->save();
        session()->forget('register_tenant');
    }

    /**
     * remember tenant app url
     */
    function rememberAppUrl()
    {
        // i an using php native cookie function to set cookie. i tried laravel functions but not working at this time
        setcookie("APPURL", $this->domain, time() + (86400 * 2.5), '');
    }

    /**
     * Get Remembered tenant app url
     * @return null
     */
    function getRememberedAppUrl()
    {
        return isset($_COOKIE['APPURL']) ? $_COOKIE['APPURL'] : null;
    }

    /**
     * return domain if tenant is loginto app
     * @return bool
     */
    function getCurrentTenantSession()
    {
        $tenantDomain = session('domain');
        if ($tenantDomain != '') {
            $tenant = SystemTenant::where('domain', $tenantDomain)->first();
            if (isset($tenant->domain) AND $tenant->domain != '') {
                return $tenant->domain;
            }
        }

        return false;
    }

    /**
     * Redirect Tenant user to app if we remembered
     * @return bool|null|string
     */
    function redirectIfRemembered()
    {
        $domain = '';
        $tenantDomain = $this->getCurrentTenantSession();


        if ($tenantDomain) {
            $domain = $tenantDomain;
        } else {
            $tenantDomain = $this->getRememberedAppUrl();
            if ($tenantDomain) {
                $domain = $tenantDomain;
            }
        }

        return $domain;

    }

    /**
     * Auto login tenant admin if first time
     */
    function doAutologin()
    {
        $user = App\Models\Tenant\User::find(1);

        if (is_null($user))
            die('Admin user not found');
        else
            Auth::login($user);

        $this->rememberAppUrl();
    }


    /**
     * @param string $route
     * @param array $param
     * @param bool $url
     * @return \Illuminate\Http\RedirectResponse|string
     */
    function route($route = '', $param = array(), $url = false)
    {
        if (!is_array($param)) {
            die('Parameters should be in array');
        }

        $domain = $this->getActualDomain();

        if (env('APP_ENV') == 'local') {
            if ($url) {
                return route($route, $param);
            }

            return redirect()->route($route, $param);
        }

        if ($url) {
            if (!isset($param['account'])) {
                $param['account'] = $domain;
            }

            return route($route, $param);
        }

        return redirect()->route($route, $domain);

    }


    /**
     * @param string $url
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function redirect($url = '')
    {
        return redirect($this->url($url));
    }


    /**
     * @param string $url
     * @return string
     */
    function url($url = '')
    {
        $subdomain = $this->getActualDomain();
        if (env('APP_ENV') == 'local') {
            return url($subdomain . '/' . trim($url, '/')) . '/';
        }

        $domain = env('APP_DOMAIN');
        $url = trim($url, '/');

        return sprintf('http://%s.%s/%s', $subdomain, $domain, $url);
    }

    /**
     * @return bool|null|string
     */
    function getActualDomain()
    {
        if ($this->domain == 'login')
            $domain = $this->redirectIfRemembered();
        else
            $domain = $this->domain;

        return $domain;
    }


    /**
     * @param null $folder
     * @param bool $create
     * @return App
     */
    function folder($folder = null, $create = false)
    {
        $tenantFile = app('App\Fastbooks\Libraries\TenantFileSystem');

        if (!is_null($folder)) {
            $tenantFile->folder($folder, $create);
        }

        return $tenantFile;
    }

}