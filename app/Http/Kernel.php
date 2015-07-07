<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'App\Http\Middleware\VerifyCsrfToken',
      //  'Clockwork\Support\Laravel\ClockworkMiddleware',


    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'         => 'App\Http\Middleware\Authenticate',
        'auth.basic'   => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
        'guest'        => 'App\Http\Middleware\RedirectIfAuthenticated',
        'auth.system'  => 'App\Http\Middleware\RedirectSystemUser',
        'guest.system' => 'App\Http\Middleware\RedirectSystemUserIfAuthenticated',
        'auth.tenant'  => 'App\Http\Middleware\RedirectTenantUser',
        'guest.tenant' => 'App\Http\Middleware\RedirectTenantUserIfAuthenticated',
        'setup.tenant' => 'App\Http\Middleware\SetupChecker',
        'preventSystem' => 'App\Http\Middleware\PreventSystemAccess',

    ];

}

