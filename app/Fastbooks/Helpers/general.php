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
    return \Auth::user();
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