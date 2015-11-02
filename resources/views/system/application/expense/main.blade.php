<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Expense Details</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Any Expense?') !!}</div>
            <div class='col-md-6'>
                <label><input type="radio" name="expense" value=1 {{($expense_action == 'edit')? 'checked=checked':''}}>Yes</label>
                <label><input type="radio" name="expense" value=0 {{($expense_action == 'add')? 'checked=checked':''}}>No</label>
            </div>
        </div>

        <div class="expense-details" style="{{($expense_action == 'edit')? '' : 'display:none'}}">
            @include('system.application.expense.'.$expense_action)
            {!!Form::hidden('expense_action', $expense_action)!!}

            <div class="add-expense-div" {{($total_expenses < 9)? '' : 'style="display: none;"'}}>
                <hr/>
                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Add up to ten expense sources') !!}</div>
                    <div class='col-md-6'>
                        <button type="button" class="btn btn-success add-expense">Add an Expense Source</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ EX::js('assets/js/application/expense.js') }}
