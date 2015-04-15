<?php
namespace APP\Http\Tenant\Collection\Controllers;
use App\Http\Controllers\Tenant\BaseController;

class CollectionController extends BaseController {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('tenant.collection.index');
    }

    public function purring()
    {
        return view('tenant.collection.purring');
    }

    public function payment()
    {
        return view('tenant.collection.payment');
    }

    public function debt()
    {
        return view('tenant.collection.debt');
    }

    public function options()
    {
        return view('tenant.collection.options');
    }

    public function courtCase()
    {
        return view('tenant.collection.case');
    }

    public function followup()
    {
        return view('tenant.collection.followup');
    }

    public function utlegg()
    {
        return view('tenant.collection.utlegg');
    }

    public function utleggFollowup()
    {
        return view('tenant.collection.utleggFollowup');
    }


}