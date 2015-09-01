<h3>Expense Details</h3>
<hr/>

@foreach($expense_details as $key => $expense_detail)
    <div class="box box-linked collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">Expense {{$key + 1}}</h3>

            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>

            </div>
        </div>
        <div class="box-body" style="display: none;">
            <div class="">
                <table class="table table-striped table-hover">
                    <tr>
                        <td class="col-md-4">Ownership</td>
                        <td class="col-md-6 applicant-content">{{get_applicant_name($expense_detail->applicant_id)}}</td>
                    </tr>
                    <tr>
                        <td class="col-md-4">Monthly Living Expense</td>
                        <td class="col-md-6 applicant-content">{{$expense_detail->monthly_living_expense}}</td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
@endforeach