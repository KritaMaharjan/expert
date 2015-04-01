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
			          <label class="date-box">New Business</label>
			        </div>
	        		<div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
			          {!! Form::label('due_date', 'Due date') !!}

			          <div class='input-group date date-box' id='due-date-picker'>
			              {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'business-date-pickers')) !!}
			              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
			              </span>
			          </div>

			        </div>
			        <div class="form-group clearfix">
			          {!! Form::label('', 'Enter share capital amount') !!}
			          <input class="form-control date-box" type="text">
			        </div>
			        <div class="form-group clearfix">
			          {!! Form::label('', 'Debit 1920 Bank') !!}
			          <input class="form-control date-box" type="text">
			        </div>
			        <div class="form-group clearfix">
			          {!! Form::label('', 'Credit 2050 Share capital') !!}
			          <input class="form-control date-box" type="text">
			        </div>
			        <div class="form-group no-mg">        
				      <div class="col-sm-offset-2">
				        <button class="btn btn-primary pull-right savebusiness" type="submit">Approve</button>
				      </div>
				    </div>
	            </form>
	        	</div>    
			</div>
        </div>
    <div>
{{ FB::js('$(function(){
		$("#business-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });
	})')}}
@stop

