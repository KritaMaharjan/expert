@extends('tenant.layouts.min')

@section('content')

	<section class="signup-section col-md-8">

		<div class="indicator pull-right">
		<div class="pull-left active">About you</div>
		<div class="pull-left step">Your business</div>
		<div class="pull-left step">Fix it now or later</div>
	</div>	

	<h3>About You</h3>
	<hr>

	<div class="signup-form">

		<form class="form-horizontal" role="form" method="POST" action="about">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

		    <div class="form-group">
		      <label class="control-label col-sm-5">Company Name</label>
		      <div class="col-sm-7 @if($errors->has('company_name')) {{'has-error'}} @endif">
		        <input type="text" class="form-control" placeholder="" name="company_name" value="{{ $company_name or old('company_name') }}">
		        @if($errors->has('company_name'))
	           		{!! $errors->first('company_name', '<label class="control-label" for="inputError">:message</label>') !!}
	          	@endif
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="control-label col-sm-5">Company Number</label>
		      <div class="col-sm-7 @if($errors->has('company_number')) {{'has-error'}} @endif">
		        <input type="text" class="form-control" placeholder=""  name="company_number" value="{{ old('company_number') }}">
		      	@if($errors->has('company_number'))
	           		{!! $errors->first('company_number', '<label class="control-label" for="inputError">:message</label>') !!}
	          	@endif
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="control-label col-sm-5">Your Name</label>
		      <div class="col-sm-7 @if($errors->has('name')) {{'has-error'}} @endif">
		        <input type="text" class="form-control" placeholder=""  name="name" value="{{ old('name') }}">
		      	@if($errors->has('name'))
	           		{!! $errors->first('name', '<label class="control-label" for="inputError">:message</label>') !!}
	          	@endif
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="control-label col-sm-5 ">Password</label>
		      <div class="col-sm-7 @if($errors->has('password')) {{'has-error'}} @endif">
		        <input type="password" class="form-control" placeholder=""  name="password" value="{{ old('password') }}">
		      	@if($errors->has('password'))
	           		{!! $errors->first('password', '<label class="control-label" for="inputError">:message</label>') !!}
	          	@endif
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="control-label col-sm-5">Confirm Password</label>
		      <div class="col-sm-7 @if($errors->has('confirm_password')) {{'has-error'}} @endif">
		        <input type="password" class="form-control" placeholder=""  name="confirm_password" value="{{ old('confirm_password') }}">
		      	@if($errors->has('confirm_password'))
	           		{!! $errors->first('confirm_password', '<label class="control-label" for="inputError">:message</label>') !!}
	          	@endif
		      </div>
		    </div>
		    
		    <div class="form-group">        
		      <div class="col-sm-offset-2 col-sm-10">
		        <button type="submit" class="btn btn-success pull-right">Next &nbsp;<i class="fa  fa-caret-right"></i></button>
		      </div>
		    </div>
	    </form>
	</div>

	</section>
	
@endsection
