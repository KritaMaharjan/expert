@extends('tenant.layouts.main')

@section('heading')
System Settings
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> Setting</li>
    <li><i class="fa fa-cog"></i> Email</li>
@stop

@section('content')
<div class="box box-solid">
	<div class="row">
		<div id="email-settings" class="col-md-6">
			<div class="inner-set-block pad">
				<h4>Customer service email</h4>
				<form method="post" name="personal_email_setting">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="group" value="personal_email_setting">	        
					<div class="form-group no-mg">
		      			<label class="control-label">SMTP Server <span>(Incoming)</span></label>
						<div class="@if($errors->has('incoming_server')) {{'has-error'}} @endif">
				        {!!Form::text('incoming_server',$support['incoming_server'],array('class' => 'form-control'))!!}  
				      	@if($errors->has('incoming_server'))
				       		{!! $errors->first('incoming_server', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					<div class="form-group no-mg">
		      			<label class="control-label">SMTP Server <span>(Outgoing)</span></label>
						<div class="@if($errors->has('outgoing_server')) {{'has-error'}} @endif">
				        {!!Form::text('outgoing_server',$support['outgoing_server'],array('class' => 'form-control'))!!}  
				      	@if($errors->has('outgoing_server'))
				       		{!! $errors->first('outgoing_server', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					<div class="form-group no-mg">
		      			<label class="control-label">Username</label>
						<div class="@if($errors->has('username')) {{'has-error'}} @endif">
				        {!!Form::text('username',$support['username'],array('class' => 'form-control'))!!}  
				      	@if($errors->has('username'))
				       		{!! $errors->first('username', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					<div class="form-group no-mg">
		      			<label class="control-label">Password</label>
						<div class="@if($errors->has('password')) {{'has-error'}} @endif">
				        <input type="password" name="password"  class="form-control" value="{{ $support['password'] }}">  
				      	@if($errors->has('password'))
				       		{!! $errors->first('password', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					<div class="form-group clearfix">        
				      <div class="col-sm-offset-2 col-sm-10">
				        <button link="{{route('tenant.setting.email')}}"  class="btn btn-success pull-right save">Save</button>
				      </div>
				    </div>
				</form>
			</div>

		</div>
		<div id="email-settings" class="col-md-6">
			<div class="inner-set-block pad">
				<h4>Personal (Admin) email</h4>
				<form method="post" name="support_email_setting">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="group" value="support_email_setting">	        
					<div class="form-group no-mg">
		      			<label class="control-label">SMTP Server <span>(Incoming)</span></label>
						<div class="@if($errors->has('incoming_server')) {{'has-error'}} @endif">
				        {!!Form::text('incoming_server',$personal['incoming_server'],array('class' => 'form-control'))!!}  
				      	@if($errors->has('incoming_server'))
				       		{!! $errors->first('incoming_server', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					<div class="form-group no-mg">
		      			<label class="control-label">SMTP Server <span>(Outgoing)</span></label>
						<div class="@if($errors->has('outgoing_server')) {{'has-error'}} @endif">
				        {!!Form::text('outgoing_server',$personal['outgoing_server'],array('class' => 'form-control'))!!}  
				      	@if($errors->has('outgoing_server'))
				       		{!! $errors->first('outgoing_server', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					<div class="form-group no-mg">
		      			<label class="control-label">Username</label>
						<div class="@if($errors->has('username')) {{'has-error'}} @endif">
				        {!!Form::text('username',$personal['username'],array('class' => 'form-control'))!!}  
				      	@if($errors->has('username'))
				       		{!! $errors->first('username', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					<div class="form-group no-mg">
		      			<label class="control-label">Password</label>
						<div class="@if($errors->has('password')) {{'has-error'}} @endif">
				        <input type="password" name="password"  class="form-control" value="{{ $personal['password'] }}">   
				      	@if($errors->has('password'))
				       		{!! $errors->first('password', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					<div class="form-group clearfix">        
				      <div class="col-sm-offset-2 col-sm-10">
				        <button link="{{route('tenant.setting.email')}}" class="btn btn-success pull-right save">Save</button>
				      </div>
				    </div>
				</form>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function () {
 
  $( '.save' ).on( 'click', function() {
        $this = $(this);
        var datatosave = $(this).closest('form').serialize();
         var url = $this.attr('link');

        $.ajax({
            url: url,
            dataType: 'json',
            data: datatosave,
            type: 'post',
            beforeSend: function()
            {
              $this.val('Loading');

              $( '.save' ).attr('disabled','disabled');
              $this.closest('form').find(".error").remove();
              $(".alert-info").remove();
            }
           })
            .done(function(data)
            {
                     if(data.status == 'true')
                      {
                         var title = $this.closest('form').prev('h4').text();
                         console.log(title);
                          $('.box-solid').before('<p class="alert alert-info">'+title+' setting updated successfully</p>');
                          $this.val('Save');
                          $( '.save' ).attr('disabled',false);
                      } else if(data.status == 'false') {
                     
                        $.each(data.errors,function(i,v){


                             $this.closest('form').find('input[name='+i+']').after('<label class="control-label error" for="inputError">'+v+'</label>');
                        });
                         $this.val('Save');
                         $( '.save' ).attr('disabled',false);
                      }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                alert('No response from server');
                $this.val('Save');
                $( '.save' ).attr('disabled',false);
            });
            return false;


    });
});
</script>


@stop