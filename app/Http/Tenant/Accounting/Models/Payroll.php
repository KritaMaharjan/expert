<?php
namespace App\Http\Tenant\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Payroll extends Model
{

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

    public function createPayroll($request)
    {
        $vacation_fund = $request['worked'] * $request['rate'] * 0.102;
        $total_salary = ($request['worked'] * $request['rate']) + $vacation_fund + $request['other_payment'];
        $payroll = Payroll::create([
            'user_id' => $request['user_id'],
            'type' => $request['type'],
            'worked' => $request['worked'],
            'rate' => $request['rate'],
            'basic_salary' => $request['worked'] * $request['rate'],
            'other_payment' => $request['other_payment'],
            'description' => $request['description'],
            'total_salary' => $total_salary,
            'tax_rate' => $request['tax_rate'],
            'payroll_tax' => $request['payroll_tax'],
            'vacation_fund' => $vacation_fund,
            'total_paid' => $total_salary,
            'payment_date' => $request['payment_date']
        ]);

        return $payroll->toArray();
    }

    public function getPayrolls($employee_id, $year='', $month='')
    {
        $query = Payroll::where('user_id', $employee_id);

        if($year != '')
            $query = $query->whereRaw('YEAR(payment_date) = '.$year);

        if($year != '')
            $query = $query->whereRaw('MONTH(payment_date) = '.$month);

        $payrolls = $query->get();
        $template = $this->getTemplate($payrolls);
        return $template;
    }

    public function getTemplate($payrolls)
    {
        $template = '';
        if(count($payrolls) > 0) {
            foreach ($payrolls as $payroll)
            {
                $type = ($payroll->type == 0)? 'Hourly' : 'Monthly';
                $template_row = '<table class="table table-hover"><tr><td><strong>Salary Type: </strong></td><td>'.$type.'</td></tr>
                <tr><td><strong>Basic Salary: </strong></td><td>'.number_format($payroll->basic_salary, 2).'</td></tr>
                <tr><td><strong>Other Payments: </strong></td><td>'.number_format($payroll->other_payment, 2).'</td></tr>
                <tr><td><strong>Total Payout: </strong></td><td>'.number_format($payroll->total_salary, 2).'</td></tr>
                <tr><td><strong>Taxes Withheld: </strong></td><td>'.number_format($payroll->tax_rate, 2).'</td></tr>
                <tr><td><strong>Vacation Fund: </strong></td><td>'.number_format($payroll->vacation_fund, 2).'</td></tr>
                <tr><td><strong>Payroll Taxes: </strong></td><td>'.number_format($payroll->payroll_tax, 2).'</td></tr></table>';
                $template = $template.$template_row;
            }
            return $template;
        }
        else {
            return "No Payrolls Added";
        }
    }

}
