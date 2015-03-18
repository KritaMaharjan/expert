<?php
namespace App\Http\Controllers\Frontend;

use Session;
use App\Models\System\Tenant as Client;
use Illuminate\Http\Request;
use App\Fastbooks\Libraries\Tenant as LibTenant;

/**
 *  Class AuthController
 * @package App\Http\Controllers\Frontend
 */
class AuthController extends BaseController {

    /**
     * @param string $activation_key
     * @return \Illuminate\View\View
     */
    public function confirm($activation_key = '')
    {
        $tenant = $this->checkActivation($activation_key);
        if (!$tenant)
            return view('errors.404');

        $tenant = $this->activateTenant($tenant);

        $url = '/?setup=' . $tenant->setup_key;

        return tenant($tenant->domain)->redirect($url);
    }

    /**
     * @param $tenant
     */
    private function saveRegistrationSession($tenant)
    {
        $registration_details = array(
            'company'    => $tenant->company,
            'guid'       => $tenant->guid,
            'domain'     => $tenant->domain,
            'email'      => $tenant->email,
            'first_time' => true
        );

        Session::put('register_tenant', $registration_details);
    }

    /**
     * @param string $tenant
     */
    private function activateTenant($tenant = '')
    {
        $tenant->setup_key = \FB::uniqueKey(15, 'tenants', 'setup_key');
        $tenant->status = 1;
        $tenant->activation_key = null;
        $tenant->save();
        $this->saveRegistrationSession($tenant);

        return $tenant;
    }

    /**
     * @param string $activation_key
     * @return bool
     */
    private function checkActivation($activation_key = '')
    {
        if (!$activation_key || $activation_key == '')
            return false;

        $tenant = Client::where('activation_key', '=', $activation_key)->first();

        if (!$tenant)
            return false;

        return $tenant;
    }

    /**
     * Store a newly created user in master database.
     *
     * @return Response
     */
    public function postRegister(Request $request)
    {
        $rules = array(
            'company' => 'required|min:4|max:55',
            'email'   => 'required|email|max:50|unique:tenants'
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails())
            return \Response::json(array('fail' => true, 'errors' => $validator->getMessageBag()->toArray()));
        else {
            $this->createTenant($request);

            return \Response::json(array('success' => true, 'redirect_url' => \URL::to('registration/success')));
        }
    }

    /**
     * Create APP user
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    private function createTenant($request)
    {
        $domain = $this->createDomain($request->company);

        $tenant = Client::create([
            'company'        => $request->company,
            'domain'         => $domain,
            'email'          => $request->email,
            'status'         => 0, //pending activation
            'activation_key' => \FB::uniqueKey(15, 'tenants', 'activation_key')
        ]);

        $this->sendConfirmationMail($tenant->activation_key, $request->username, $request->email);
        //return redirect('/');
    }

    /**
     * Create APP
     * @param $string
     * @return mixed|string
     */
    function createDomain($string)
    {
        $string = explode(' ', $string);
        $string = strtolower($string[0]);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $string);
        $domain = preg_replace("/[\/_|+ -]+/", '-', $clean);

        $domain = $this->checkDomainExists($domain);

        return $domain;
    }

    /**
     * get Subdomain suggestion
     * @param string $company_name
     * @return mixed
     */
    public function getDomainSuggestion($company_name = '')
    {
        $domain = $this->createDomain($company_name);

        return \Response::json($domain);
    }

    /**
     * Check subdomain exist for not
     * @param string $domain
     * @return string
     */
    private function checkDomainExists($domain = '')
    {
        $i = 1;
        $exists = Client::where('domain', $domain)->first();
        $new_domain = $domain;
        while ($exists) {
            $new_domain = $domain . $i;
            $exists = Client::where('domain', $new_domain)->first();
            $i++;
        }

        return $new_domain;
    }


    /**
     * Send activation code in user's email
     * @param string $activation_key
     * @param string $username
     * @param string $email
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    private function sendConfirmationMail($activation_key = '', $username = '', $email = '')
    {
        $link = \URL::to('account/verify/' . $activation_key);
        \FB::sendEmail($email, $username, 'confirmation_email', ['{{NAME}}' => $username, '{{ACTIVATION_URL}}' => $link]);
        $message = 'Thanks for signing up! Please check your email for activation instructions.';
        \Flash::success($message);

        return redirect('/');
    }


    /**
     * Display Login page or redirect user's APP url
     * @param LibTenant $tenant
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    function login(LibTenant $tenant)
    {
        $domain = $tenant->redirectIfRemembered();
        if ($domain != '') {
            return tenant($domain)->redirect('/');
        }

        return view('frontend.pages.login');
    }

    /**
     * process URL request form
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function sendRequestUrl(Request $request)
    {
        $validator = \Validator::make($request->all(), array('email' => 'required|email|exists:tenants'));
        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        $this->sendUrlMail($request->email);
        \Flash::success('An email containing domain URL been sent successfully.');

        return redirect('login');
    }


    /**
     * Send APP URL to user's email
     * @param string $to_email
     * @return bool
     */
    private function sendUrlMail($to_email = '')
    {
        $user = Client::where('email', $to_email)->first();
        if ($user) {
            return \FB::sendEmail($to_email, $user->fullname, 'request_url', ['{{NAME}}' => 'name', '{{APP_URL}}' => \URL::to($user->domain)]);
        } else {
            return false;
        }

    }


    /**
     * Display success message
     * @return \Illuminate\View\View
     */
    public function getSuccess()
    {
        return view('frontend/pages/success');
    }

} 