@extends('tenant.layouts.min')

@section('content')

	<div class="signup-content">
			<section class="signup-section col-md-8">

 				<div class="indicator pull-right">
					<div class="pull-left passed">About you</div>
					<div class="pull-left active">Your business</div>
					<div class="pull-left step">Fix it now or later</div>
				</div>	

				<h3>Your Business</h3>
				<hr>

				<div class="signup-form">
					{!! Form::open(array('url' => tenant()->url('setup/business'), 'method'=>'POST', 'class'=>'form-horizontal')) !!}
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					    <div class="form-group">
					      <label class="control-label col-sm-5">Entity Type</label>
					      <div class="col-sm-7 @if($errors->has('entity_type')) {{'has-error'}} @endif">
					      	{!! Form::select('entity_type', 
					      								[
					      									'' => 'Select Entity', 
					      									'llc' => 'LLC',
					      									'inc' => 'INC',
					      									'sole-trader' => 'Sole Trader',
					      									'inc' => 'Charity',
					      									'others' => 'Others'
				      									], '', array('class' => 'full-width')) !!}
							 @if($errors->has('entity_type'))
				           		{!! $errors->first('entity_type', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-5">VAT Repoting Rule</label>
					      <div class="col-sm-7 @if($errors->has('vat_reporting_rule')) {{'has-error'}} @endif">
					      	{!! Form::select('vat_reporting_rule', 
					      								[
					      									'' => 'Select Rule', 
					      									'annual' => 'Annual',
					      									'inc' => 'INC',
					      									'6-times-a-year' => '6 times a year',
					      									'not-registered' => 'Not registered'
				      									], '', array('class' => 'full-width')) !!}
					  		@if($errors->has('vat_reporting_rule'))
				           		{!! $errors->first('vat_reporting_rule', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-5">Account Number</label>
					      <div class="col-sm-7 @if($errors->has('account_no')) {{'has-error'}} @endif">
					      	{!!Form::text('account_no','',array('class' => 'form-control'))!!}
					     	@if($errors->has('account_no'))
				           		{!! $errors->first('account_no', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-5">Address</label>
					      <div class="col-sm-7 @if($errors->has('address')) {{'has-error'}} @endif">
					      	{!!Form::text('address','',array('class' => 'form-control'))!!}  
					     	@if($errors->has('address'))
				           		{!! $errors->first('address', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-5">Potal Code/Town</label>
					      <div class="col-sm-7 two-inputs @if($errors->has('postal_code') || $errors->has('town')) {{'has-error'}} @endif">
					      	{!!Form::text('postal_code','',array('class' => 'form-control', 'id' => 'postal_code'))!!}  
					      	{!!Form::text('town','',array('class' => 'form-control', 'id' => 'city'))!!} 
					     	@if($errors->has('postal_code'))
				           		{!! $errors->first('postal_code', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif
					      	@if($errors->has('town'))
				           		{!! $errors->first('town', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif 
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-5">Country</label>
					      <div class="col-sm-7 @if($errors->has('country')) {{'has-error'}} @endif">
					      	{!! Form::select('country', $countries, 'NO', array('class' => 'full-width')) !!}
							@if($errors->has('country'))
				           		{!! $errors->first('country', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif

					      </div>
					    </div>
					    
					    
					    <div class="form-group">        
					      <div class="col-sm-offset-2 col-sm-10">
					        <button type="submit" class="btn btn-primary pull-right">Next &nbsp;<i class="fa  fa-caret-right"></i></button>
					      </div>
					    </div>
				    {!! Form::close() !!}
				</div>

			</section>
		</div>
<?php //FB::js("jquery-ui.js"); ?>
<?php //FB::js("postal.js"); ?>
<?php //FB::js("autocomplete.js"); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
	
@endsection
