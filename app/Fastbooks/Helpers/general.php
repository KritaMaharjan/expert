<?php

/**
 * Show 404 page
 */
function show_404()
{
    App()->abort('404');
}


function tenant($domain = null)
{
    $tenant = app('App\Fastbooks\Libraries\Tenant');

    if (!is_null($domain)) {
        $tenant->setDomain($domain);
    }

    return $tenant;
}


function plupload()
{
    $plupload = app('App\Fastbooks\Plupload\Plupload');

    return $plupload;
}


function current_user()
{
    $user = \Auth::user();
    $user->profile = \App\Models\Tenant\Profile::firstOrCreate(['user_id' => $user->id]);
    $user->display_name = $user->fullname;
    $user->smtp = (object)$user->profile->smtp;
    $user->smtp->email = (isset($user->smtp->email)) ? $user->smtp->email : $user->email;

    return $user;
}


function tenant_route($route, $param = array())
{
    if (env('APP_ENV') == 'local') {
        return route($route, $param);
    }

    return tenant()->route($route, $param, true);
}

function page_title()
{
    $path = Request::path();
    $title = explode('/', $path);
    $title = array_reverse($title);
    $title = array_filter($title);
    if (count($title) > 0)
        return ucwords(join(' / ', $title)) . ' - ' . env('APP_TITLE');
    else
        return env('APP_TITLE');

}

function site_url()
{
    return 'http://' . env('APP_DOMAIN');
}

function email_date($dateTime)
{
    $date = \Carbon::createFromTimeStamp(strtotime($dateTime));

    if ($date->isToday()) {
        return $date->format('h:i a');
    } elseif ($date->year == date('Y')) {
        return $date->format('M d');
    } else {
        return $date->format('M d, Y');
    }
}

function format_telephone($phone_number = null)
{

    if ($phone_number == null || strlen($phone_number))
        return $phone_number;
    $cleaned = preg_replace('/[^[:digit:]]/', '', $phone_number);
    preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);

    return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
}

function format_date($date)
{
    $formatted_date = date('d-m-y', strtotime($date));

    return $formatted_date;
}

function format_id($id = 0, $zeros = 3)
{
    $id = sprintf("%0" . $zeros . "d", $id);

    return $id;
}