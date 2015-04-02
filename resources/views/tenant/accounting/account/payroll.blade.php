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
            		<form>
		            	<div class="form-group clearfix">
				         	<select class="form-control half-width2 pull-left">
				         		<option>Select employee</option>
				         		<option>user1</option>
				         		<option>user2</option>
				         		<option>user3</option>
				         	</select>
							<div class="date-box">					         	
					         	<select class="form-control">
					         		<option>Salary type</option>
					         		<option>Hourly</option>
					         		<option>Monthly</option>
					         	</select>
				         	</div>

				        </div>
		        		<div class="form-group clearfix">
				          {!! Form::label('', 'Rate per hour') !!}
				          <input class="form-control date-box" type="text">
				        </div>
				        
				        <div class="form-group clearfix">
				          {!! Form::label('', 'Hours') !!}
				          <input class="form-control date-box" type="text">
				        </div>
				        <div class="form-group clearfix">
				          {!! Form::label('', 'Total wages') !!}
				          <input class="form-control date-box" type="text">
				        </div>
				        <p><strong>Other payments?</strong></p>
				        <hr class="mg-top-0">

				        <div class="form-group clearfix">
				          {!! Form::label('', 'Amount') !!}
				          <input class="form-control date-box" type="text">
				        </div>
				        <div class="form-group clearfix">
				          {!! Form::label('', 'Text') !!}
				          <input class="form-control date-box" type="text">
				        </div>

				        <div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
				          {!! Form::label('due_date', 'Date paid out') !!}

				          <div class='input-group date date-box' id='due-date-picker'>
				              {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'paidout-date-pickers')) !!}
				              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
				              </span>
				          </div>

				        </div>

				        <br />
				        <p>
				        	<strong>Witholdings</strong>				        	
				        </p>
				        <hr class="mg-top-0">
				        <div class="form-group clearfix">
				          {!! Form::label('', 'Tax withheld') !!}
				          <input class="form-control date-box" type="text">
				        </div>
				        <div class="form-group clearfix">
				          {!! Form::label('', 'Vacation fund') !!}
				          <input class="form-control date-box" type="text" placeholder="%">
				        </div>
				        <div class="form-group clearfix">
				          {!! Form::label('', 'Payroll tax') !!}
				          <input class="form-control date-box" type="text" placeholder="%">
				        </div><br />
						<div class="form-group clearfix">        
					        <div>
					        	<button class="btn btn-primary pull-right savebusiness" type="submit">Make payslip</button>
					        </div>
					    </div>
				       
		            </form>
            	</div>
            	
            </div>
            
        </div>
    <div>
    {{ FB::js('$(function(){
		$("#paidout-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });
        $(".select-multiple").select2({
			theme: "classic"
		});

	})')}}
@stop