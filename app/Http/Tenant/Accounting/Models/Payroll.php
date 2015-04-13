<?php
namespace App\Http\Tenant\Accounting\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Payroll extends Model {

    protected $table = "fb_payroll";

    protected $fillable = ['user_id', 'type', 'worked', 'rate', 'basic_salary', 'other_payment', 'description', 'total_salary', 'tax_rate', 'payroll_tax', 'vacation_fund', 'total_paid', 'payment_date'];

    protected $primaryKey = "id";

    function dataTablePagination(Request $request, array $select = array())
    {

        if ((is_array($select) AND count($select) < 1)) {
            $select = "*";
        }

        $take = ($request->input('length') > 0) ? $request->input('length') : 15;
        $start = ($request->input('start') > 0) ? $request->input('start') : 0;

        $search = $request->input('search');
        $search = $search['value'];
        $order = $request->input('order');
        $column_id = $order[0]['column'];
        $columns = $request->input('columns');
        $orderColumn = $columns[$column_id]['data'];
        $orderdir = $order[0]['dir'];

        $payroll = array();
        $query = $this->select($select);

        if ($orderColumn != '' AND $orderdir != '') {
            $query = $query->orderBy($orderColumn, $orderdir);
        } else {
            $query = $query->orderBy('id', 'desc');
        }

        if ($search != '') {
            $query = $query->where('name', 'LIKE', "%$search%");
        }
        $payroll['total'] = $query->count();


        $query->skip($start)->take($take);

        $data = $query->get();

        foreach ($data as $key => &$value) {
            $value->created = $value->created_at->format('d-M-Y');
            $value->DT_RowId = "row-" . $value->id;
        }

        $payroll['data'] = $data->toArray();

        $json = new \stdClass();
        $json->draw = ($request->input('draw') > 0) ? $request->input('draw') : 1;
        $json->recordsTotal = $payroll['total'];
        $json->recordsFiltered = $payroll['total'];
        $json->data = $payroll['data'];

        return $json;
    }



    function toData()
    {
        $this->show_url = tenant()->url('payroll/' . $this->id);
        $this->edit_url = tenant()->url('payroll/' . $this->id . '/edit');

        return $this->toArray();
    }

    public function createPayroll($request, $user_id)
    {
        $payroll = Payroll::create([
            'user_id'           => $request['user_id'],
            'type'           => $request['type'],
            'worked'          => $request['worked'],
            'user_id'        => $request['worked'],
            'dob'            => $dob,
            'street_name'    => $request['street_name'],
            'street_number'  => $request['street_number'],
            'telephone'      => $request['telephone'],
            'mobile'         => $request['mobile'],
            'postcode'       => $postal_code[0],
            'town'           => $request['town'],
            'status'         => $request['status'],
        ]);
        $payroll_add['data'] = $this->toFomatedData($payroll);
        $payroll_add['edit_url'] = tenant()->url('payroll/' . $payroll->id . '/edit');
        $payroll_add['template'] = $this->getTemplate($payroll);

        return $payroll_add;
    }

    public function updatePayroll($id, $details, $dob)
    {

        $postal_code = explode(',', $details['postcode']);

        $payroll = Payroll::where('id', $id)->first();
        $payroll->type = $details['type'];
        $payroll->name = $details['name'];
        $payroll->email = $details['email'];
        $payroll->user_id = current_user()->id;
        $payroll->dob = $dob;
        $payroll->street_name = $details['street_name'];
        $payroll->street_number = $details['street_number'];
        $payroll->telephone = $details['telephone'];
        $payroll->mobile = $details['mobile'];
        $payroll->postcode = $postal_code[0];
        $payroll->town = $details['town'];
        $payroll->status = $details['status'];
        $payroll->save();


        $updated_payroll['data'] = $this->toFomatedData($payroll);
        $updated_payroll['template'] = $this->getTemplate($payroll);
        $updated_payroll['edit_url'] = tenant()->url('payroll/' . $id . '/edit');

        return $updated_payroll;
    }

    public function getTemplate($details = '')
    {
        $details->payrollName = $details->name;

        $details->created = $details->created_at->format('d-M-Y');


        $template = "<td>" . $details->fullname . "</td>
                     <td>" . $details->created . "</td>
                     <td>" . $details->email . "</td>
                     <td>" . $details->status . "</td>";

        return $template;
    }

    function toFomatedData($data)
    {
        foreach ($data as $k => &$items) {
            $this->toArray();
        }

        return $data;
    }
}
