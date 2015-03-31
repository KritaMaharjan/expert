@extends('tenant.layouts.main')

@section('heading')
New Business
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body clearfix">
	        <div class="col-md-6">
	            <label>Open accounting year - New Business</label>
	            <form>
	        		<div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
			          {!! Form::label('due_date', 'Due date') !!}

			          <div class='input-group date date-box' id='due-date-picker'>
			              {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'business-date-pickers')) !!}
			              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
			              </span>
			          </div>

			        </div>
	            </form>
	        </div>    

        </div>
    <div>
{{ FB::js('$(function(){
		$("#business-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });
	})')}}
@stop

