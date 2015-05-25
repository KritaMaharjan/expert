@extends('tenant.layouts.main')

@section('heading')
Profile Settings
@stop

@section('breadcrumb')
    @parent
     <li><i class="fa fa-cog"></i><a href="{{tenant_route('tenant.profile')}}">Profile</a></li>
    <li><i class="fa fa-cog"></i>Edit Profile</li>
@stop

@section('content')

<div class="box box-solid">
	<div class="row">
		<div id="email-settings" class="col-md-12">
			<div class="inner-set-block box-body">
				<!-- <h4>User Setting</h4> -->
				<form name="user_setting" enctype='multipart/form-data' method="post" route="{{tenant_route('tenant.edit.profile')}}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="group" value="userSetting">	   
					<div class="row">
						<div class="form-group col-md-12">
							<label>Upload Photo</label>
							<div class="clear"></div>
							<div class="col-md-3 uplod">

                            {!! (!empty($setting['photo']))? '<img src='.tenant()->folder("system")->url().$setting["photo"].' class="photo"><input type="hidden" class="edit-attachment" name="photo" value='.$setting["photo"].' />' : '' !!}
							<div id="container" style="{{ (!empty($setting['photo']))? 'display:none':'' }}">
                                  <div id="uploader">
                                        <div class="image-section">
                                            Drop your file
                                        </div>
                                  </div>
                            </div>

                            @if(!empty($setting['photo']))
                                <div id='edit-filelist'>
                                    {{ $setting['photo'] }}
                                    <a class="cancel_upload" data-url="{{ $setting['photo'] }}" href="#"><i class="fa fa-times"></i></a>
                                </div>
                            @endif

                            <div id='filelist'>
                                Your browser doesn't have Flash, Silverlight or HTML5 support.
                            </div>

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
							<div class="@if($errors->has('social_security_number')) {{'has-error'}} @endif">
					        {!!Form::text('social_security_number',$setting['social_security_number'],array('class' => 'form-control'))!!}  
					      	@if($errors->has('social_security_number'))
					       		{!! $errors->first('social_security_number', '<label class="control-label" for="inputError">:message</label>') !!}
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
						<div class="half-width">
			      			<label class="control-label">Postcode</label>
							<div class="@if($errors->has('postcode')) {{'has-error'}} @endif">
					        {!!Form::text('postcode',$setting['postcode'],array('class' => 'form-control'))!!}  
					        
					      	@if($errors->has('postcode'))
					       		{!! $errors->first('postcode', '<label class="control-label" for="inputError">:message</label>') !!}
					      	@endif
					       </div>
				       </div>

				       <div class="half-width">
				      	<label class="control-label">Town</label>
						<div class="@if($errors->has('town')) {{'has-error'}} @endif">
							{!!Form::text('town',$setting['town'] ,array('class' => 'form-control', 'id' => 'city'))!!}
					      	@if($errors->has('town'))
					       		{!! $errors->first('town', '<label class="control-label" for="inputError">:message</label>') !!}
					      	@endif
				      	</div>
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
							<div class="@if($errors->has('tax_card')) {{'has-error'}} @endif">
					        {!!Form::text('tax_card',$setting['tax_card'],array('class' => 'form-control'))!!}  
					      	@if($errors->has('tax_card'))
					       		{!! $errors->first('tax_card', '<label class="control-label" for="inputError">:message</label>') !!}
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

{{FB::js('assets/plugins/plupload/js/plupload.full.min.js')}}
<?php
$successCallback ="
  var response = JSON.parse(object.response);
  var wrap = $('#'+file.id);
  wrap.append('<input type=\"hidden\" class=\"attachment\" name=\"photo\" value=\"'+response.data.fileName+'\" />');
  wrap.append('<a href=\"#\" data-action=\"compose\" data-url=\"'+response.data.fileName+'\" class=\"cancel_upload\" ><i class=\"fa fa-times\"></i></a>');
  $('#container').hide();
  $('.photo').remove();
  $('#container').before('<img class=\"photo\" src='+response.data.pathName+'/>');
";
FB::js(plupload()->button('uploader')->maxSize('20mb')->mimeTypes('image')->url(url('file/upload/data?folder=system'))->autoStart(true)->success($successCallback)->init());

$js ="$(document).on('click', '.cancel_upload', function (e) {
              e.preventDefault();
              var url = $(this).data('url');
              var wrap = $(this).parent();
              var action = $(this).data('action');

              if (!confirm('Are you sure, you want to delete file?')) return false;

              if (action == 'compose') {
                  $.ajax({
                      url: appUrl + 'file/delete',
                      type: 'GET',
                      dataType: 'json',
                      data: {file: url, folder:'expense'}
                  })
                      .done(function (response) {
                          if (response.status == 1) {
                              wrap.remove();
                              $('.photo').remove();
                              $('#container').show();
                          }
                          else {
                              alert(response.data.error);
                          }
                      })
                      .fail(function () {
                          alert('Connect error!');
                      })
              }
              else {
                  $('#edit-filelist').remove();
                  wrap.remove();
                  $('.photo').remove();
                  $('.edit-attachment').remove();
                  $('#container').show();
              }
          });";
FB::js($js);

?>