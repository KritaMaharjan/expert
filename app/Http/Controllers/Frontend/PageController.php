<?php
namespace App\Http\Controllers\Frontend;


class PageController extends BaseController {


    function home()
    {
        return view('frontend.home');
    }

    function features()
    {
        return view('frontend.pages.features');

    }

    function contact()
    {
        return view('frontend.pages.contact');

    }

    function about()
    {
        return view('frontend.pages.about');

    }

} 