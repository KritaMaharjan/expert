@extends('tenant.layouts.main')

@section('heading')
Pay an employee
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
        	<div class="box-header pad-0">
                <h3 class="box-title">Pay out</h3>
            </div>
            <div class="row mg-btm-40">
            	<div class="col-md-6">
            		{!! Form::open(array('method'=>'POST', 'id'=>'payroll-form')) !!}
		            	<div class="form-group clearfix  {{ ($errors->has('user_id'))? 'has-error': '' }}">
		            	    <label class="half-width2">
                                {!! Form::select('user_id', array('' => 'Select Employee'), null, array('class' => 'form-control pull-left', 'id' => 'select-employee')) !!}
                                @if($errors->has('user_id'))
                                    {!! $errors->first('user_id', '<label class="control-label" for="inputError">:message</label>') !!}
                                @endif
                            </label>

							<div class="date-box">
                                {!! Form::select('type', array('' => 'Select Type', 0 => 'Hourly', 1 => 'Monthly'), null, array('class' => 'form-control type')) !!}
					         	@if($errors->has('type'))
                                    {!! $errors->first('type', '<label class="control-label" for="inputError">:message</label>') !!}
                                @endif
				         	</div>

				        </div>

		        		<div class="form-group clearfix  {{ ($errors->has('rate'))? 'has-error': '' }}">
				          {!! Form::label('', 'Rate per hour', array('class' => 'rate')) !!}
				          <div class="date-box">
				          {!! Form::text('rate', NULL, array('class' => 'form-control')) !!}
				            @if($errors->has('rate'))
                                {!! $errors->first('rate', '<label class="control-label" for="inputError">:message</label>') !!}
                            @endif
                           </div>
				        </div>

				        <div class="form-group clearfix  {{ ($errors->has('worked'))? 'has-error': '' }}">
				          {!! Form::label('', 'Hours', array('class' => 'worked')) !!}
				          <div class="date-box">

					          {!! Form::text('worked', NULL, array('class' => 'form-control')) !!}
					          @if($errors->has('worked'))
	                              {!! $errors->first('worked', '<label class="control-label" for="inputError">:message</label>') !!}
	                          @endif
                           </div>
				        </div>

				        <p><strong>Other payments?</strong></p>
				        <hr class="mg-top-0">

				        <div class="form-group clearfix  {{ ($errors->has('other_payment'))? 'has-error': '' }}">
				          {!! Form::label('', 'Amount') !!}
				          <div class="date-box">
					          {!! Form::text('other_payment', NULL, array('class' => 'form-control')) !!}
					          @if($errors->has('other_payment'))
	                                {!! $errors->first('other_payment', '<label class="control-label" for="inputError">:message</label>') !!}
	                            @endif
                           </div>
				        </div>

				        <div class="form-group clearfix  {{ ($errors->has('description'))? 'has-error': '' }}">
				          {!! Form::label('', 'Text') !!}
				          <div class="date-box">
					          {!! Form::textarea('description', NULL, array('class' => 'form-control')) !!}
					          @if($errors->has('description'))
	                                {!! $errors->first('description', '<label class="control-label" for="inputError">:message</label>') !!}
	                            @endif
                           </div>
				        </div>

				        <br />
				        <p>
				        	<strong>Witholdings</strong>
				        </p>
				        <hr class="mg-top-0">
				        <div class="form-group clearfix  {{ ($errors->has('tax_rate'))? 'has-error': '' }}">
				          {!! Form::label('', 'Tax withheld') !!}
				          <div class="date-box">
					          {!! Form::text('tax_rate', NULL, array('class' => 'form-control', 'placeholder' => '')) !!}
					          @if($errors->has('tax_rate'))
	                                {!! $errors->first('tax_rate', '<label class="control-label" for="inputError">:message</label>') !!}
	                            @endif
                          </div>
				          
				        </div>
				        <div class="form-group clearfix  {{ ($errors->has('payroll_tax'))? 'has-error': '' }}">
				          {!! Form::label('', 'Payroll tax') !!}
				          <div class="date-box">
					          {!! Form::text('payroll_tax', NULL, array('class' => 'form-control date-box')) !!}
					          @if($errors->has('payroll_tax'))
	                                {!! $errors->first('payroll_tax', '<label class="control-label" for="inputError">:message</label>') !!}
	                            @endif
                           </div>
				        </div><br />

				        <p>
				            <strong>Payment Details</strong>
				        </p>
				        <hr class="mg-top-0">

				        <div class="form-group clearfix  {{ ($errors->has('vacation_fund'))? 'has-error': '' }}">
                            {!! Form::label('', 'Vacation fund') !!}
                            <div class="date-box">
                                {!! Form::text('vacation_fund', null, array('class' => 'form-control date-box', 'readonly' => 'readonly')) !!}
                                @if($errors->has('vacation_fund'))
                                    {!! $errors->first('vacation_fund', '<label class="control-label" for="inputError">:message</label>') !!}
                                @endif
                            </div>
                        </div>

                        <div class="form-group clearfix">
                              {!! Form::label('', 'Total wages') !!}
                              <div class="date-box">
                                  {!! Form::text('basic_salary', NULL, array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                              </div>
                        </div>

				        <div class="form-group clearfix  {{ ($errors->has('payment_date'))? 'has-error': '' }}">
				          {!! Form::label('payment_date', 'Date paid out') !!}
				          <div class="date-box">

					          <div class='input-group date' id='due-date-picker'>
					              {!! Form::text('payment_date', null, array('class' => 'form-control date-box', 'id' =>'paidout-date-pickers')) !!}

					              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
					              </span>
					          </div>
					          @if($errors->has('payment_date'))
	                                {!! $errors->first('payment_date', '<label class="control-label" for="inputError">:message</label>') !!}
	                          @endif
					       </div>
					    </div>

						<div class="form-group clearfix">
					        <div>
					        	<button class="btn btn-primary pull-right savebusiness" type="submit">Make payslip</button>
					        </div>
					    </div>
				       
		            {!! Form::close() !!}
            	</div>
            	
            </div>
            
        </div>
    <div>

    {{ FB::js('assets/js/payroll.js')}}
@stop