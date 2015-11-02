<div class="new-expense">
    <h2>Expense <span class="expense-num">1</span> Details</h2>
    <hr/>
    <div class="form-group">
        <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
        <div class='col-md-6'>
            <button type="button" class="btn btn-danger remove-expense">Remove this expense
            </button>
        </div>
    </div>
    <div class="form-group">
        <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
        <div class='col-md-6'>
            <select name="expense_applicant_id[]" class="form-control">
                @foreach($applicants as $key => $applicant)
                    <option value="{{$key}}">{{$applicant}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group @if($errors->has('monthly_living_expense')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('Monthly Living Expense') !!}</div>
        <div class='col-md-6'>
            <input name="monthly_living_expense[]" class="form-control"/>
            @if($errors->has('monthly_living_expense'))
                {!! $errors->first('monthly_living_expense', '<label class="control-label"
                                                         for="inputError">:message</label>')!!}
            @endif
        </div>
    </div>

</div>