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

function format_datetime($date)
{
    $formatted_date = date('M d, Y h:i a', strtotime($date));
    return $formatted_date;
}

function format_id($id = 0, $zeros = 3)
{
    $id = sprintf("%0" . $zeros . "d", $id);

    return $id;
}

function calculate_todo_time($date, $completed = false) {
    $actual_difference = strtotime($date) - strtotime(date('Y-m-d H:i:s'));
    $seconds = abs($actual_difference);

    $months = floor($seconds / (3600*24*30));
    $day = floor($seconds / (3600*24));
    $hours = floor($seconds / 3600);
    $mins = floor(($seconds - ($hours*3600)) / 60);
    $secs = floor($seconds % 60);

    if($seconds < 60)
        $time = $secs." seconds";
    else if($seconds < 60*60 )
        $time = $mins." min";
    else if($seconds < 24*60*60)
        $time = $hours." hours";
    else if($seconds > 24*60*60 && $seconds < 24*60*60*30)
        $time = $day." days";
    else
        $time = $months." months";

    if($completed == true)
        return '<small class="label label-success"><i class="fa fa-clock-o"></i> '.$time.' ago</small>';
    elseif($actual_difference < 0)
        return '<small class="label label-danger"><i class="fa fa-warning"></i> '.$time.'</small>';
    elseif($seconds < 24*60*60)
        return '<small class="label label-warning"><i class="fa fa-clock-o"></i> '.$time.'</small>';
    else if($seconds > 24*60*60 && $seconds < 24*60*60*30)
        return '<small class="label label-info"><i class="fa fa-clock-o"></i> '.$time.'</small>';
    else
        return '<small class="label label-default"><i class="fa fa-clock-o"></i> '.$time.'</small>';
}