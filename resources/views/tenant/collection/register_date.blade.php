@extends('tenant.layouts.main')

@section('heading')
Register Court Date
@stop

@section('breadcrumb')
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">

        		<form>
            						<div class="form-group clearfix">
            				          {!! Form::label('', 'Select file to upload') !!}
            				          <input class="date-box" type="file">
            				        </div>
            				        <p class="align-right"><a href="#" class="btn btn-default btn-small" title="Upload">Upload</a></p>

            		        		<div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
            				          {!! Form::label('due_date', 'Court date') !!}

            				          <div class='input-group date date-box' id='due-date-picker'>
            				              {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'billing-date-pickers')) !!}
            				              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
            				              </span>
            				          </div>
            				        </div>
            				        <p class="align-right"><a href="#" class="btn btn-primary btn-small" title="Add to my calander">Add to my calander</a></p>
            			        </form>

        </div>
    </div>
@stop