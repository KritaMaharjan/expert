<?php
//include('routes/tenant.php');
include('routes/frontend.php');
include('routes/system.php');

Validator::extend('validArrayEmail', function ($attribute, $value, $parameters) {
    $emails = explode(';', $value);
    $emails = array_map('trim', $emails);
    $emails = array_filter($emails);

    foreach ($emails as $k => $email) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }
    }

    return true;

});

Validator::extend('maxValue', function ($attribute, $value, $parameters) {
    if($parameters[0] >= $value)
        return true;
    else
        return false;
});

Validator::extend('minPaymentValue', function ($attribute, $value) {
    if(0 < $value)
        return true;
    else
        return false;
});

Validator::extend('passcheck', function ($attribute, $value, $parameters)
{
    return Hash::check($value, Auth::user()->getAuthPassword());
});