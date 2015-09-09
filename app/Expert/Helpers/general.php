<?php

/**
 * Show 404 page
 */
function show_404()
{
    App()->abort('404');
}

function current_user()
{
    $user = \Auth::user();
    $user->isAdmin = ($user->role == 1);
    $user->isUser = ($user->role == 2);

    return $user;
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

function readable_date($date)
{
    $formatted_date = date('M d, Y', strtotime($date));
    return $formatted_date;
}

function format_datetime($date)
{
    $formatted_date = date('M d, Y h:i a', strtotime($date));
    return $formatted_date;
}

function format_only_date($date)
{
    $formatted_date = date('M d, Y', strtotime($date));
    return $formatted_date;
}

function short_date($date)
{
    $formatted_date = date('jS M', strtotime($date));
    return $formatted_date;
}

function format_id($id = 0, $zeros = 3)
{
    $id = sprintf("%0" . $zeros . "d", $id);

    return $id;
}

function data_decode($data)
{
    return @unserialize($data);
}

function data_encode($data)
{
    return @serialize($data);
}

function get_today_date()
{
    $today = Carbon\Carbon::now();
    return $today->toDateString();
}

function float_format($number, $digits = 2)
{
    return number_format($number, $digits);
}

function get_client_name($client_id)
{
    $client = \App\Models\System\Client\Client::select('given_name', 'surname')->find($client_id);
    $name = (!empty($client)) ? $client->given_name.' '.$client->surname : 'Undefined';

    return $name;
}

function get_user_name($user_id)
{
    $user = \App\Models\System\User\User::select('given_name', 'surname')->find($user_id);
    $name = (!empty($user)) ? $user->given_name.' '.$user->surname : 'Undefined';
    return $name;
}

function get_applicant_name($applicant_id)
{
    $applicant = \App\Models\System\Application\Applicant::select('given_name', 'surname')->find($applicant_id);
    $name = (!empty($applicant)) ? $applicant->given_name.' '.$applicant->surname : 'Undefined';
    return $name;
}

function get_role($user_id = '')
{
    if($user_id == '') $role = current_user()->role;
    else $role = \App\Models\System\User\User::select('role')->find($user_id)->role;
    $user_roles = \Config::get('general.user_role');
    return $user_roles[$role];
}

function get_phone_icon($type)
{
    switch ($type) {
        case 'home':
            return 'fa-home';
            break;
        case 'work':
            return 'fa-suitcase';
            break;
        case 'mobile':
            return 'fa-mobile';
            break;
        default:
            return 'fa-phone';
    }

}