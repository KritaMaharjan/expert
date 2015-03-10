<?php
/**
 * User: manishg.singh
 * Date: 2/19/2015
 * Time: 9:52 AM
 */

function setLang($lang)
{
    App::setLocale($lang);
    Session::put('language',$lang);
}

function getCurrentLang()
{
    return session()->get('language');
}

function _lang($lang = '')
{
    echo Lang::get($lang);
}

function lang($lang = '')
{
    return Lang::get($lang);
}
