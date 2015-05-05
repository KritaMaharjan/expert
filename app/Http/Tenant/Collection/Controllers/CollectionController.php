<?php
namespace APP\Http\Tenant\Collection\Controllers;

use App\Http\Controllers\Tenant\BaseController;
use App\Http\Tenant\Collection\Repository\CollectionRepository;
use Illuminate\Http\Request;

class CollectionController extends BaseController {

    /**
     * @var CollectionRepository
     */
    private $repo;
    /**
     * @var Request
     */
    private $request;

    public function __construct(CollectionRepository $repo, Request $request)
    {
        parent::__construct();
        $this->repo = $repo;
        $this->request = $request;
    }

    public function index()
    {
        return view('tenant.collection.index');
    }


    public function waiting()
    {
        return view('tenant.collection.waiting');
    }

    public function addCase()
    {
        return view('tenant.collection.add_case');
    }

    public function makeCollectionCase()
    {
        if ($this->request->ajax()) {
            $id = $this->request->route('id');
            if ($this->repo->makeCase($id)) {
                return $this->success(['message' => 'Bill add to collection case']);
            }

            return $this->fail(['message' => 'Bill couldn\'t converted to collection case']);
        }
    }

    public function data()
    {
        if ($this->request->ajax()) {
            $collectionWaiting = $this->repo->billsOnCollection();
            echo json_encode($collectionWaiting, JSON_PRETTY_PRINT);
        }
    }

    public function waitingData()
    {
        if ($this->request->ajax()) {
            $collectionWaiting = $this->repo->billsWaitingCollection();
            echo json_encode($collectionWaiting, JSON_PRETTY_PRINT);
        }
    }


    /*

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
    }*/


}