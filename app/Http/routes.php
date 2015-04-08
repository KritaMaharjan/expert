<?php
include('routes/tenant.php');
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