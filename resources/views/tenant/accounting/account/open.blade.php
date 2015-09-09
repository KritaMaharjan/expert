@extends('tenant.layouts.main')

@section('heading')
New Business
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body clearfix">
        	<div class="row">
	        	<div class="col-md-6">
	            <form>
	            	<div class="form-group clearfix">
			          {!! Form::label('', 'Open accounting year -') !!}
			          <label class="date-box">When you have previously done accounting elsewhere</label>
			        </div>
	        		<div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
			          {!! Form::label('due_date', 'What date do you want to start Fastbooks year from?',array('class' => 'half-width')) !!}

			          <div class='input-group date date-box' id='due-date-picker'>
			              {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'year-date-pickers')) !!}
			              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
			              </span>
			          </div>

			        </div><br />
			        <div class="form-group clearfix">        
				      <div class="col-sm-offset-2">
				        <button class="btn btn-primary pull-right savebusiness" type="submit">New Line</button>
				      </div>
				    </div>
			        <div class="form-group clearfix">
			          {!! Form::label('', 'Amount') !!}
			          <input class="form-control date-box" type="text">
			        </div>
			        <div class="form-group clearfix">
			          {!! Form::label('', 'Debit account') !!}
			          <input class="form-control date-box" type="text">
			        </div>
	            </form>
	        	</div>    
			</div>
        </div>
    <div>
{{ FB::js('$(function(){
		$("#year-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });
	})')}}
@stop

