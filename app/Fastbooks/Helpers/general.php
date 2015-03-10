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

    if ( ! is_null($domain))
    {
        $tenant->setDomain($domain);
    }

    return $tenant;
}



function current_user()
{
    return \Auth::user();
}