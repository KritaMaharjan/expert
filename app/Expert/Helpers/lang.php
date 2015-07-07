<?php
/**
 * User: manishg.singh
 * Date: 2/19/2015
 * Time: 9:52 AM
 */



function _lang($lang = '')
{
    echo Lang::get($lang);
}

function lang($lang = '')
{
    return Lang::get($lang);
}
