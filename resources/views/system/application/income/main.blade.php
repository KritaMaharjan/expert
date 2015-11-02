<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Income Details</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <div class='col-md-2 control-label'>{!!Form::label('Any Income?') !!}</div>
            <div class='col-md-6'>
                <label><input type="radio" name="income"
                              value=1 {{($action == 'edit')? 'checked=checked':''}}>Yes</label>
                <label><input type="radio" name="income" value=0 {{($action == 'add')? 'checked=checked':''}}>No</label>
            </div>
        </div>

        <div class="income-details" style="{{($action == 'edit')? '' : 'display:none'}}">
            @include('system.application.income.'.$action)
            {!!Form::hidden('action', $action)!!}

            <div class="add-income-div">
                <hr/>
                <div class="form-group">
                    <div class='col-md-2 control-label'>{!!Form::label('Add up to ten income sources') !!}</div>
                    <div class='col-md-6'>
                        <button type="button" class="btn btn-success add-income">Add an Income Source</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ EX::js('assets/js/application/income.js') }}