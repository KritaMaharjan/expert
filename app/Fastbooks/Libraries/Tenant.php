<?php
namespace App\Fastbooks\Libraries;

use App;
use DB;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use App\Models\System\Tenant as SystemTenant;
use App\Models\Tenant\User;
use App\Models\Tenant\Setting as TenantSettings;
use App\Fastbooks\Libraries\TenantTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

/**
 * Class Tenant
 * @package App\Fastbooks\Libraries
 */
class Tenant {

    // prefix for database
    /**
     *
     */
    /**
     * Database settings
     */
    protected $DB_username;
    protected $DB_password;
    protected $DB_prefix;

    /**
     * @var string
     */
    protected $connection = 'tenant';
    protected $tenant_db;
    protected $request;
    protected $tenantUser;
    protected $createTable;
    protected $auth;
    protected $domain;


    /**
     * @param Request $request
     * @param User $user
     * @param TenantTable $TenantTable
     * @param Guard $auth
     */
    function __construct(Request $request, User $user, TenantTable $TenantTable, TenantSettings $TenantSettings, Guard $auth)
    {
        $this->init();
        $this->tenatUser = $user;
        $this->tenantSettings = $TenantSettings;
        $this->createTable = $TenantTable;
        $this->auth = $auth;
        $this->request = $request;
        $this->setDomain($this->getSubdomain());
        $this->tenant_db = $this->DB_prefix . $this->domain;

    }

    function init()
    {
        $config = App::make('config');
        $setting = $config->get('tenant.database');
        $this->DB_username = $setting['username'];
        $this->DB_password = $setting['password'];
        $this->DB_prefix = $setting['db_prefix'];

    }


    /**
     * Connect to Tenant database
     * @param string $username
     * @param string $password
     */
    function connectTenantDB($username = '', $password = '')
    {
        // Just get access to the config.
        $config = App::make('config');

        // Now we simply copy the Tenant connection information to our new connection.
        $newConnection = $config->get('database.connections.' . $this->connection);

        // Override the database name.
        $newConnection['database'] = $this->tenant_db;
        $newConnection['username'] = ($username == '') ? $this->DB_username : $username;
        $newConnection['password'] = ($password == '') ? $this->DB_password : $password;
        // This will add our new connection to the run-time configuration for the duration of the request.
        App::make('config')->set('database.connections.' . $this->connection, $newConnection);

        // make tenant as default connection
        App::make('config')->set('database.default', $this->connection);
    }


    /**
     * Create database and tables for a tenant when first time landed on APP
     */
    function setupTenantDatabase()
    {
        // create tenant DB
        $this->createNewTenantDB();

        //Connect to Tenant DB
        $this->connectTenantDB();

        //create Tenant Tables
        $this->createTenantTables();

        //insert tenant admin data
        $this->dataInsert();
    }

    /**
     * Create Database for tenant
     */
    public function createNewTenantDB()
    {
        DB::statement('CREATE DATABASE IF NOT EXISTS ' . $this->tenant_db);
    }

    /**
     * Create tables for tenant
     */
    function createTenantTables()
    {
        $this->createTable->users();
        $this->createTable->settings();
        $this->createTable->profile();
        $this->createTable->passwordReset();
        $this->createTable->customers();
        $this->createTable->products();
        $this->createTable->inventory();
    }


    /**
     * Add Data to tables
     */
    function dataInsert()
    {
        $tenantInfoInSystem = $this->getTenantinfo();
        $user = $this->tenatUser->findOrNew(1);
        $user->email = $tenantInfoInSystem->email;
        $user->role = 1; // Admin Role
        $user->guid = $tenantInfoInSystem->guid;
        $user->status = 1; // Activated
        $user->first_time = 1; // yes first time
        $user->save();

        // update company name in setting table
        $setting = $this->tenantSettings->firstOrNew(['name' => 'company']);
        $setting->value = serialize(array('company_name' => $tenantInfoInSystem->company));
        $setting->save();

        // update domain in setting table
        $setting = $this->tenantSettings->firstOrNew(array('name' => 'domain'));
        $setting->value = $tenantInfoInSystem->domain;
        $setting->save();
    }


    /**
     * Validate Subdomain and authenticate tenant if first time then auto login
     */
    function authenticateTenant()
    {
        if ($this->isValidSubDomain()):

            if ($this->isFirstTime()) {
                // register tenant database
                $this->setupTenantDatabase();

                $this->doAutologin();

                session()->forget('register_tenant');
                $user = $this->getTenantinfo();
                $user->is_new = 0;
                $user->save();

            } else {
                $this->connectTenantDB();
                try {
                    DB::getDatabaseName();
                } catch (Exception $e) {
                    die('Could not connect to database');
                }
            }
        endif;
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
     */
    function isFirstTime()
    {
        $user = $this->getTenantinfo();
        if (isset($user->is_new) AND $user->is_new == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * remember tenant app url
     */
    function rememberAppUrl()
    {
        // i an using php native cookie function to set cookie i tried laravel functions but not working at this time
        setcookie("APPURL", $this->domain, time() + (86400 * 2.5), '/');
        //setcookie("APPURL", $this->domain, time() + (86400 * 365 * 5), '/');
        session()->put('APPURL', $this->domain);
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
        $tenantDomain = session('APPURL');
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
            if (!empty($param)) {
                $param = array_push($param, ['account' => $domain]);
            }
            $param = ['account' => $param];

            return route($route, $param);
        }

        return redirect()->route($route, $domain);

    }


    function redirect($url = '')
    {
        $domain = $this->getActualDomain();

        if (env('APP_ENV') == 'local') {
            return redirect($domain . '/' . trim($url, '/'));
        }

        return redirect('http://' . $domain . '.mashbooks.no/' . trim($url, '/'));
    }


    function url($url = '')
    {
        $domain = $this->getActualDomain();
        if (env('APP_ENV') == 'local') {
            return url($domain . '/' . trim($url, '/'));
        }

        return 'http://' . $domain . '.mashbooks.no/' . trim($url, '/');

    }

    function getActualDomain()
    {
        if ($this->domain == 'login')
            $domain = $this->redirectIfRemembered();
        else
            $domain = $this->domain;

        return $domain;
    }

}