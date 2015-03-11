@extends('tenant.layouts.min')

@section('content')

	<div class="signup-content">
			<section class="signup-section col-md-8">

 				<div class="indicator pull-right">
					<div class="pull-left passed">About you</div>
					<div class="pull-left passed">Your business</div>
					<div class="pull-left active">Fix it now or later</div>
				</div>	

				<h3>Fix it now or later</h3>
				<hr>

				{{--@if (count($errors) > 0)
					<div class="alert alert-danger">
						<strong>Whoops!</strong> There were some problems with your input.<br><br>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif--}}

				<div class="signup-form">

					{!! Form::open(array('url' => tenant()->url('setup/fix'), 'method'=>'POST', 'files'=>true, 'class'=>'form-horizontal')) !!}
				        
				        <div class="form-group">
					      <label class="control-label col-sm-5" name="swift_num" value="{{ old('swift_num') }}">Swift Number</label>
					      <div class="col-sm-7  @if($errors->has('swift_num')) {{'has-error'}} @endif">
					      	{!!Form::text('swift_num','',array('class' => 'form-control'))!!}  
					      	@if($errors->has('swift_num'))
				           		{!! $errors->first('swift_num', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-5" name="iban_num" value="{{ old('iban_num') }}">IBAN Number</label>
					      <div class="col-sm-7  @if($errors->has('iban_num')) {{'has-error'}} @endif">
					      	{!!Form::text('iban_num','',array('class' => 'form-control'))!!}  
					      	@if($errors->has('iban_num'))
				           		{!! $errors->first('iban_num', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-5" name="telephone" value="{{ old('telephone') }}">Telephone</label>
					      <div class="col-sm-7  @if($errors->has('telephone')) {{'has-error'}} @endif">
					      	{!!Form::text('telephone','',array('class' => 'form-control'))!!}  
					      	@if($errors->has('telephone'))
				           		{!! $errors->first('telephone', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-5" name="fax" value="{{ old('fax') }}">Fax</label>
					      <div class="col-sm-7  @if($errors->has('fax')) {{'has-error'}} @endif">
					      	{!!Form::text('fax','',array('class' => 'form-control'))!!}  
					      	@if($errors->has('fax'))
				           		{!! $errors->first('fax', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-5" name="website" value="{{ old('website') }}">Website</label>
					      <div class="col-sm-7  @if($errors->has('website')) {{'has-error'}} @endif">
					      	{!!Form::text('website','',array('class' => 'form-control'))!!}  
					      	@if($errors->has('website'))
				           		{!! $errors->first('website', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif
					      </div>
					    </div>
					    <div class="form-group">
					      <label class="control-label col-sm-5" name="service_email" value="{{ old('service_email') }}">Business Customer Service Email</label>
					      <div class="col-sm-7  @if($errors->has('service_email')) {{'has-error'}} @endif">
					      	{!!Form::email('service_email','',array('class' => 'form-control'))!!}  
					      	@if($errors->has('service_email'))
				           		{!! $errors->first('service_email', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif
					      </div>
					    </div>

				        <div class="form-group">
					      <label class="control-label col-sm-5">Upload Logo</label>
					      <div class="col-sm-7  @if($errors->has('logo')) {{'has-error'}} @endif">
					        {!! Form::file('logo') !!}
					        @if($errors->has('logo'))
				           		{!! $errors->first('logo', '<label class="control-label" for="inputError">:message</label>') !!}
				          	@endif
					      </div>
					    </div>
					    
					    
					    <div class="form-group">        
					      <div class="col-sm-offset-2 col-sm-10">
					      	 {!! Form::button('Log In &nbsp;<i class="fa  fa-sign-in"></i>', array('class'=>'btn btn-primary pull-right', 'type'=>'submit')) !!}
					        <!-- <button type="submit" class="btn btn-primary pull-right">Log In &nbsp;<i class="fa  fa-sign-in"></i></button> -->
					      </div>
					    </div>
			        <div id="success"> </div>
				    {!! Form::close() !!}
				</div>

			</section>
		</div>
@endsection