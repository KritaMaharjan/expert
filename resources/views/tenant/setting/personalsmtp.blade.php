<form method="post" name="personal_email_setting" class="form-horizontal">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
  						<input type="hidden" name="group" value="smtp">	        
					<div class="form-group no-mg">
		      			<label class="control-label">SMTP Server <span>(Incoming)</span></label>
						<div class="@if($errors->has('incoming_server')) {{'has-error'}} @endif">
						<input class="form-control" name="incoming_server" value="<?php echo isset($smtp['incoming_server'])?$smtp['incoming_server']:'';?>" >
				       
				      	@if($errors->has('incoming_server'))
				       		{!! $errors->first('incoming_server', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					<div class="form-group no-mg">
		      			<label class="control-label">SMTP Server <span>(Outgoing)</span></label>
						<div class="@if($errors->has('outgoing_server')) {{'has-error'}} @endif">

				        <input class="form-control" name="outgoing_server" value="<?php echo isset($smtp['outgoing_server'])?$smtp['outgoing_server']:'';?>" >
				      	@if($errors->has('outgoing_server'))
				       		{!! $errors->first('outgoing_server', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					<div class="form-group no-mg">
		      			<label class="control-label">Email</label>
						<div class="@if($errors->has('email')) {{'has-error'}} @endif">
				       
				         <input class="form-control" name="email" value="<?php echo isset($smtp['email'])?$smtp['email']:'';?>" >  
				      	@if($errors->has('email'))
				       		{!! $errors->first('email', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					<div class="form-group no-mg">
		      			<label class="control-label">Password</label>
						<div class="@if($errors->has('password')) {{'has-error'}} @endif">
				        <input type="password" name="password"  class="form-control" value="<?php echo isset($smtp['password'])?$smtp['password']:'';?>">  
				      	@if($errors->has('password'))
				       		{!! $errors->first('password', '<label class="control-label" for="inputError">:message</label>') !!}
				      	@endif
				      </div>
					</div>
					<div class="form-group clearfix">        
				      <div class="col-sm-offset-2 col-sm-10">
				        <button link="{{tenant_route('tenant.setting.email')}}"  class="btn btn-success pull-right save">Save</button>
				      </div>
				    </div>
				</form>