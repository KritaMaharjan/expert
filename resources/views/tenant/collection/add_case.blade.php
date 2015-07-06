<div class="box box-solid">
    <div class="box-header">
          <h3 class="box-title">Add new case</h3>
    </div>
    <div>
        {!! Form::open(array('method'=>'POST', 'files'=>true, 'id'=>'add-case-form')) !!}
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('invoice_num', 'Invoice Number') !!}
                {!! Form::text('invoice_num',null,['class'=>'date-box form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('invoice_amount', 'Invoice Amount') !!}
                {!! Form::text('invoice_amount',null,['class'=>'date-box form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('due_date', 'Invoice Due Date') !!}
                <div id="due_date" class="date-box input-group date">
                    {!! Form::text('due_date', null,['class'=>'form-control', 'id' =>'due-date-picker']) !!}
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('Steps') !!}
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

            <div class="form-group">
                {!! Form::label('step_due_date', 'Step Due Date') !!}
                <div id="due_date" class="date-box input-group date">
                    {!! Form::text('step_due_date', null,['class'=>'form-control', 'id' =>'step-date-picker']) !!}
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            {{--<div class="form-group">
                {!! Form::label('fee', 'Fee') !!}
                {!! Form::text('fee',null,['class'=>'date-box form-control']) !!}
            </div>--}}

            <div class="form-group">
                {!! Form::label('kid', 'KID') !!}
                {!! Form::text('kid',null,['class'=>'date-box form-control']) !!}
            </div>

            <div class="form-group">
                <label id="paid-box">{!! Form::checkbox('is_paid', null, false, array('class' => 'icheck')) !!} &nbsp;&nbsp;The bill is already paid.</label>
            </div>

            <div class="form-group">
                <div id="after-paid" style="display:none">
                    <div class="form-group clearfix">
                        {!! Form::label('', 'Paid from') !!}
                        <div class="date-box">
                            {!! Form::select('payment_method', [1 => 'Cash', 2 =>'Bank account'] , null, array('class' => 'form-control pull-left')) !!}
                        </div>
                    </div>
                    <div class="form-group clearfix {{ ($errors->has('amount_paid'))? 'has-error' : '' }}">
                        {!! Form::label('', 'Amount paid') !!}
                        {!! Form:: text('amount_paid', null, array('class' => 'form-control date-box', 'id' => 'amount_paid')) !!}
                        @if($errors->has('amount_paid'))
                             {!! $errors->first('amount_paid', '<label class="control-label error error-right" for="inputError">:message</label>') !!}
                        @endif
                    </div>
                    <div class="form-group clearfix {{ ($errors->has('payment_date'))? 'has-error': '' }}">
                        {!! Form::label('payment_date', 'Paid date') !!}

                        <div class='input-group date date-box' id='payment_date'>
                            {!! Form:: text('payment_date', null, array('class' => 'form-control', 'id' =>'payment-date-picker')) !!}
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div><br />
                </div>
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

    /* Date pickers */
    $('#due-date-picker').datepicker({format: 'yyyy-mm-dd', startDate: '+1d',todayHighlight:false, autoclose: true})
    .on('changeDate', function(selected){
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#step-date-picker').datepicker('setStartDate', startDate);
    });

    $('#step-date-picker').datepicker({format: 'yyyy-mm-dd', startDate: '+1d',todayHighlight:false, autoclose: true});

    $('#payment-date-picker').datepicker({format: 'yyyy-mm-dd', endDate: new Date(),todayHighlight:true, autoclose: true});

    /* Checkbox */
    var icheck = $('.icheck').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue',
        tap: true
    });

    /* Payment */
    $(document).on('ifChecked', '#paid-box .icheck', function (e) {
        $("#after-paid").show("slow");
    });

    $(document).on('ifUnchecked', '#paid-box .icheck', function (e) {
        $("#after-paid").hide("slow");
    });

    /* Add Case form submit */
    $(document).on('submit', '#add-case-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = form.attr('action');
        var formData = form.serialize();

        form.find('.case-submit').val('loading...');
        form.find('.case-submit').attr('disabled', true);

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();
        form.find('.callout').remove();

        $.ajax({
            url: formAction,
            type: 'POST',
            dataType: 'json',
            data: formData
        })
            .done(function (response) {
                if (response.success == true || response.status == 1) {

                    $('#fb-modal').modal('hide');
                    $('.mainContainer .box-solid').before(notify('success', 'Case Added Successfully!'));
                }
                else {
                    if (response.status == 'fail') {
                        $.each(response.errors, function (i, v) {
                            $('.modal-body #' + i).parent().addClass('has-error');
                            $('.modal-body #' + i).after('<label class="error error-' + i + '">' + v[0] + '<label>');
                        });
                    }
                }
            })
            .fail(function () {
                alert('something went wrong');
            })
            .always(function () {
                form.find('.case-submit').removeAttr('disabled');
                form.find('.case-submit').val('Save');
            });
    });

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }

</script>