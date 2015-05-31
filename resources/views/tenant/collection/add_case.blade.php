<div class="box box-solid">
    <div class="box-header">
          <h3 class="box-title">Edit User</h3>
    </div>
    <div>
        {!! Form::open(array('method'=>'POST', 'files'=>true, 'id'=>'add-case-form')) !!}
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('invoice_num', 'Invoice Number') !!}
                {!! Form::text('invoice_num',null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('invoice_amount', 'Invoice Number') !!}
                {!! Form::text('invoice_amount',null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('due_date', 'Invoice Due Date') !!}
                <div id="due_date" class="input-group date">
                    {!! Form::text('due_date', null,['class'=>'form-control', 'id' =>'due-date-picker']) !!}
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="form-group">
                Steps
            </div>
            <div class="form-group">
                {!! Form::radio('step', 'purring', true, ['id' => 'purring']); !!}
                {!! Form::label('purring', 'Purring') !!}
            </div>
            <div class="form-group">
                {!! Form::radio('step', 'inkassovarsel', null, ['id' => 'inkassovarsel']); !!}
                {!! Form::label('inkassovarsel', 'Inkassovarsel') !!}
            </div>
            <div class="form-group">
                {!! Form::radio('step', 'betalingsoppfording', null, ['id' => 'betalingsoppfording']); !!}
                {!! Form::label('betalingsoppfording', 'Betalingsoppfording') !!}
            </div>
            <div class="form-group">
                {!! Form::radio('step', 'court', null, ['id' => 'court']); !!}
                {!! Form::label('court', 'Court Case') !!}
            </div>
            <div class="form-group">
                {!! Form::radio('step', 'utlegg', null, ['id' => 'utlegg']); !!}
                {!! Form::label('utlegg', 'Utlegg') !!}
            </div>

        </div>
        <div class="box-footer clearfix">
            {!! Form::button('Save', array('class'=>'btn btn-primary pull-right case-submit', 'type'=>'submit')) !!}
        </div>
        {!! Form::close() !!}
    </div>
    </div>
</div>

<script type="text/javascript">
    $('#due-date-picker').datepicker({format: 'yyyy-mm-dd', startDate: '+1d',todayHighlight:false, autoclose: true});
</script>