<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectTenantUser {



    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;

    }



    /**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $this->validateTenant();


        if(isset($this->auth->user()->status)) {
            if ($this->auth->user()->status == 0) {
                $this->auth->logout();
                flash()->error(lang('Your account has not been activated.'));
            } elseif ($this->auth->user()->status == 2) {
                $this->auth->logout();
                flash()->error(lang('Your account has been suspended.'));
            } elseif ($this->auth->user()->status == 3) {
                $this->auth->logout();
                flash()->error(lang('Your account has been permanently blocked.'));
            }
        }


        if ($this->auth->guest())
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                return tenant()->route('tenant.login');
            }
        }

		return $next($request);
	}

    function validateTenant()
    {
        $tenant =\App::make('App\Fastbooks\Libraries\Tenant');
        $tenant->authenticateTenant();
    }
}
