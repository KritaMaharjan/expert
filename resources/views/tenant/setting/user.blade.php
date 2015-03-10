@extends('tenant.layouts.main')

@section('heading')
Profile Settings
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> Setting</li>
    <li><i class="fa fa-cog"></i> User</li>
@stop

@section('content')

<div class="box box-solid">
	<div class="row">
		<div id="email-settings" class="col-md-12">
			<div class="inner-set-block box-body">
				<!-- <h4>User Setting</h4> -->
				<form name="user_setting" enctype='multipart/form-data' method="post" route="{{route('tenant.setting.user')}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="group" value="userSetting">	   
					<div class="row">
						<div class="form-group col-md-12">
							<label>Upload Photo</label>
							<div class="clear"></div>
							<div class="col-md-3 uplod">
						      <img src="{{ asset('img/upload-pic.png')}}" class="uploaded-img">
						  	  </div>
						     <div class="col-md-6 mrg-mng">
						       <input type="file" name="photo">						       
						      </div>						      
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
			      			<label class="control-label">Name</label>
							<div class="@if($errors->has('name')) {{'has-error'}} @endif">
					        {!!Form::text('name',$setting['name'],array('class' => 'form-control'))!!}  
					      	@if($errors->has('name'))
					       		{!! $errors->first('name', '<label class="control-label" for="inputError">:message</label>') !!}
					      	@endif
					      </div>
						</div>
					
					
						<div class="form-group col-md-6">
			      			<label class="control-label">Social security number</label>
							<div class="@if($errors->has('security_number')) {{'has-error'}} @endif">
					        {!!Form::text('security_number',$setting['security_number'],array('class' => 'form-control'))!!}  
					      	@if($errors->has('security_number'))
					       		{!! $errors->first('security_number', '<label class="control-label" for="inputError">:message</label>') !!}
					      	@endif
					      </div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
			      			<label class="control-label">Email</label>
							<div class="@if($errors->has('email')) {{'has-error'}} @endif">
					        {!!Form::email('email',$setting['email'],array('class' => 'form-control'))!!}  
					      	@if($errors->has('email'))
					       		{!! $errors->first('email', '<label class="control-label" for="inputError">:message</label>') !!}
					      	@endif
					      </div>
						</div>
					
					
						<div class="form-group col-md-6">
			      			<label class="control-label">Phone</label>
							<div class="@if($errors->has('phone')) {{'has-error'}} @endif">
					        {!!Form::text('phone',$setting['phone'],array('class' => 'form-control'))!!}  
					      	@if($errors->has('phone'))
					       		{!! $errors->first('phone', '<label class="control-label" for="inputError">:message</label>') !!}
					      	@endif
					      </div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
			      			<label class="control-label">Address</label>
							<div class="@if($errors->has('address')) {{'has-error'}} @endif">
					        {!!Form::text('address',$setting['address'],array('class' => 'form-control'))!!}  
					      	@if($errors->has('address'))
					       		{!! $errors->first('address', '<label class="control-label" for="inputError">:message</label>') !!}
					      	@endif
					      </div>
						</div>
						
					<div class="form-group col-md-6">
		      			<label class="control-label">Postcode and town</label>
						<div class="@if($errors->has('postcode')) {{'has-error'}} @endif">
				        {!!Form::text('postcode',$setting['postcode'],array('class' => 'form-control'))!!}  
				      	@if($errors->has('postcode'))
				       		{!! $errors->first('postcode', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
			      			<label class="control-label">Comments</label>
							<div class="@if($errors->has('comment')) {{'has-error'}} @endif">
					        {!!Form::text('comment',$setting['comment'],array('class' => 'form-control'))!!}  
					      	@if($errors->has('comment'))
					       		{!! $errors->first('comment', '<label class="control-label" for="inputError">:message</label>') !!}
					      	@endif
					      </div>
						</div>
					
					
						<div class="form-group col-md-6">
			      			<label class="control-label"><span>Tax Card</span></label>
							<div class="@if($errors->has('tax')) {{'has-error'}} @endif">
					        {!!Form::text('tax',$setting['tax'],array('class' => 'form-control'))!!}  
					      	@if($errors->has('tax'))
					       		{!! $errors->first('tax', '<label class="control-label" for="inputError">:message</label>') !!}
					      	@endif
					      </div>
						</div>					
					</div>
					<div class="form-group clearfix">        
				      <div class="col-sm-offset-2 col-sm-10">
				        <button type="submit" class="btn btn-success pull-right">Save</button>
				      </div>
				    </div>
				</form>
			</div>
		</div>		
	</div>
</div>

@stop