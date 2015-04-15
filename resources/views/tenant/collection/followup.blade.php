@extends('tenant.layouts.main')

@section('heading')
Court Case Follow Up
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
        	<!-- <div class="box-header pad-0">
                <h3 class=	"box-title"></h3>
            </div> -->

            <div class="row">
	            <div class="col-md-6">
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
			        <hr>
			        <div class="row">
			        	<div class="col-md-6">			        		
			        		<ul class="no-list-style">
			        			<li><h5><strong>Case history:</h5></strong></h5>
			        				<ul>
			        				</ul>
			        			</li>
			        			<li>
			        				<h5><strong>Collection steps:</strong></h5>
			        				<ul>
			        					<li>Invoice.pdf</li>
			        					<li>Inkassovarsel.pdf</li>
			        					<li>Betalingsoppfording.pdf</li>
			        					<li>Forliksklage.pdf</li>
			        				</ul>
			        			</li>
			        			<li>
			        				<h5><strong>Communication:</strong></h5>
			        				<ul>
			        					<li>List of select emails by subject</li>
			        				</ul>
			        			</li>
			        			<li>
			        				<h5><strong>Feedback from court:</strong></h5>
			        				<ul>
			        					<li>Whichever file the upload in this</li>
			        				</ul>
			        			</li>
			        		</ul>

			        	</div>
			        	<div class="col-md-6 align-right pad-top-50">
			        		<p><a href="#" class="btn btn-primary" title="Won the case">Won the case</a></p>
			        		<p><a href="#" class="btn btn-primary" title="Lost the case">Lost the case</a></p>
			        		<p><a href="#" class="btn btn-danger" title="Cancel case">Cancel case</a></p>
			        	</div>
			        </div>
		        </div>
        	</div>
        </div>
    </div>


{{--Load JS--}}
{{FB::registerModal()}}
{{ FB::js('$(function(){
		$("#billing-date-pickers").datetimepicker({
        });       
	})')}}
@stop