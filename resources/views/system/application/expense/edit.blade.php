@foreach($expense_details as $ex_key => $expense_detail)
    <div class="new-expense">
        <h2>Expense <span class="expense-num">{{$ex_key + 1}}</span> Details</h2>
        <hr/>
        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
            <div class='col-md-6'>
                <button type="button" class="btn btn-danger remove-expense">Remove this expense
                </button>
            </div>
        </div>
        <input type="hidden" name="expense_id[{{$ex_key}}]" value="{{$expense_detail->id}}"/>
        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
            <div class='col-md-6'>
                <select name="applicant_id[{{$ex_key}}]" class="form-control">
                    @foreach($applicants as $key => $applicant)
                        <option value="{{$key}}" {{($expense_detail->applicant_id == $key)? "selected='selected'":''}}>{{$applicant}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group @if($errors->has('monthly_living_expense')) {{'has-error'}} @endif">
            <div class='col-md-2 control-label'>{!!Form::label('Monthly Living Expense') !!}</div>
            <div class='col-md-6'>
                <input name="monthly_living_expense[{{$ex_key}}]" class="form-control" value="{{$expense_detail->monthly_living_expense}}"/>
                @if($errors->has('monthly_living_expense'))
                    {!! $errors->first('monthly_living_expense', '<label class="control-label"
                                                             for="inputError">:message</label>')!!}
                @endif
            </div>
        </div>

    </div>
@endforeach