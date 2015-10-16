<?php
namespace App\Models\System\Lender;

use App\Models\System\Application\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Lender extends Model
{

    protected $table = 'lenders';
    protected $fillable = ['company_name', 'contact_name', 'added_by_users_id'];

    function add(array $request)
    {
        $lender = Lender::create([
            'company_name' => $request['company_name'],
            'contact_name' => $request['contact_name'],
            'job_title' => $request['job_title'],
            'title' => $request['title'],
            'preferred_name' => $request['preferred_name'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'abn' => $request['abn'],
            'occupation' => $request['occupation'],
            'commission' => $request['commission'],
            'added_by_users_id' => \Auth::user()->id
        ]);
        return $lender->id;
    }

    function edit(array $request, $lender_id)
    {
        $lender = Lender::find($lender_id);
        $lender->company_name = $request['company_name'];
        $lender->contact_name = $request['contact_name'];
        $lender->job_title = $request['job_title'];
        $lender->title = $request['title'];
        $lender->preferred_name = $request['preferred_name'];
        $lender->first_name = $request['first_name'];
        $lender->last_name = $request['last_name'];
        $lender->phone = $request['phone'];
        $lender->email = $request['email'];
        $lender->abn = $request['abn'];
        $lender->occupation = $request['occupation'];
        $lender->commission = $request['commission'];
        $lender->save();
    }

    /* Assign lead to sales person */
    function assign(array $request, $application_id)
    {
        DB::beginTransaction();

        try {
            $application = Application::find($application_id);

            ApplicationLender::create([
                'description' => $request['description'],
                'lender_id' => $request['lender_id'],
                'application_id' => $application_id,
                'status' => 0,
            ]);

            $application->submitted = 1;
            $application->save();

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    /* *
     *  Display data for ajax pagination
     *  Output stdClass
     * */
    function dataTablePagination(Request $request, array $select = array())
    {
        if ((is_array($select) AND count($select) < 1)) {
            $select = "*";
        }
        $take = ($request->input('length') > 0) ? $request->input('length') : 10;
        $start = ($request->input('start') > 0) ? $request->input('start') : 0;

        $search = $request->input('search');
        $search = $search['value'];
        $order = $request->input('order');
        $column_id = $order[0]['column'];
        $columns = $request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $user = array();
        $query = $this->select($select);

        if ($orderColumn != '' AND $orderdir != '') {
            $query = $query->orderBy($orderColumn, $orderdir);
        }

        $query = $query->where('id', '!=', \Auth::user()->id);
        $user['total'] = $query->count();

        $query->skip($start)->take($take);

        $data = $query->get();

        foreach ($data as $key => &$value) {
            $value->DT_RowId = "row-" . $value->id;
        }
        $user['data'] = $data->toArray();
        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $user['total'];
        $json->recordsFiltered = $user['total'];
        $json->data = $user['data'];

        return $json;
    }
} 