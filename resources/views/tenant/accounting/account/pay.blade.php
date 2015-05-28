<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">Register the bill as paid</h3>
    </div>
    <div class="box-body">
        {!!Form::open(['id'=>'payment-form'])!!}
            <div class="form-group clearfix">
                {!! Form::label('', 'Paid from') !!}
                {!! Form::select('payment_method', [1 => 'Cash', 2 =>'Bank account'] , null, array('class' => 'form-control half-width2 pull-right')) !!}
            </div>
            <div class="form-group clearfix">
                {!! Form::label('', 'Amount paid') !!}
                {!! Form:: text('amount_paid', null, array('class' => 'form-control date-box', 'id' => 'amount_paid')) !!}
            </div>

            <div class="form-group clearfix {{ ($errors->has('payment_date'))? 'has-error': '' }}">
              {!! Form::label('payment_date', 'Paid date') !!}
                  <div id="due_date" class="input-group date date-box">
                      {!! Form:: text('payment_date', null, array('class' => 'form-control due_date', 'id' =>'pay-date-picker')) !!}
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
            </div><br />
            <div class="form-group clearfix">
                <div>
                    <button class="btn btn-primary pull-right payment-submit" type="submit">Register expense</button>
                </div>
            </div>
        {!!Form::close()!!}
    </div>
</div>

<script type="text/javascript">
    $('#pay-date-picker').datepicker({format: 'yyyy-mm-dd',endDate :new Date()});
</script>