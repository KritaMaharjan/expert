{!! Form::open(array('url' => tenant()->url('setup/about'), 'method'=>'POST', 'class'=>'form-horizontal')) !!}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group no-mg">
      <label class="control-label">Company Name</label>
      <div class="@if($errors->has('company_name')) {{'has-error'}} @endif">
      	{!!Form::text('company_name','',array('class' => 'form-control'))!!}  
        @if($errors->has('company_name'))
       		{!! $errors->first('company_name', '<label class="control-label" for="inputError">:message</label>') !!}
      	@endif
      </div>
    </div>
    <div class="form-group no-mg">
      <label class="control-label">Company Number</label>
      <div class="@if($errors->has('company_number')) {{'has-error'}} @endif">
        {!!Form::text('company_number','',array('class' => 'form-control'))!!}  
      	@if($errors->has('company_number'))
       		{!! $errors->first('company_number', '<label class="control-label" for="inputError">:message</label>') !!}
      	@endif
      </div>
    </div>
    <div class="form-group no-mg">
      <label class="control-label">Your Name</label>
      <div class="@if($errors->has('name')) {{'has-error'}} @endif">
        {!!Form::text('name','',array('class' => 'form-control'))!!}  
      	@if($errors->has('name'))
       		{!! $errors->first('name', '<label class="control-label" for="inputError">:message</label>') !!}
      	@endif
      </div>
    </div>
    
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-success pull-right">Next &nbsp;<i class="fa  fa-caret-right"></i></button>
      </div>
    </div>
{!! Form::close() !!}