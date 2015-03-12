{!! Form::open(array('url' => tenant()->url('setting/system'), 'method'=>'POST', 'class'=>'form-horizontal')) !!}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="group" value="business">
		<div class="form-group no-mg">
	      <label class="control-label">Company Name</label>
	      <div class="@if($errors->has('company_name')) {{'has-error'}} @endif">
	      	{!!Form::text('company_name', Input::old($company['company_name']),array('class' => 'form-control'))!!}  
	        @if($errors->has('company_name'))
	       		{!! $errors->first('company_name', '<label class="control-label" for="inputError">:message</label>') !!}
	      	@endif
	      </div>
	    </div>
	    <div class="form-group no-mg">
	      <label class="control-label">Company Number</label>
	      <div class="@if($errors->has('company_number')) {{'has-error'}} @endif">
	        {!!Form::text('company_number',Input::old($company['company_number']),array('class' => 'form-control'))!!}  
	      	@if($errors->has('company_number'))
	       		{!! $errors->first('company_number', '<label class="control-label" for="inputError">:message</label>') !!}
	      	@endif
	      </div>
	    </div>
	    <div class="form-group no-mg">
	      <label class="control-label">Entity Type</label>
	      <div class="@if($errors->has('entity_type')) {{'has-error'}} @endif">
	      	{!! Form::select('entity_type', 
	      								[
	      									'' => 'Select Entity', 
	      									'llc' => 'LLC',
	      									'inc' => 'INC',
	      									'sole-trader' => 'Sole Trader',
	      									'inc' => 'Charity',
	      									'others' => 'Others'
      									], $business['entity_type'], array('class' => 'form-control')) !!}
			 @if($errors->has('entity_type'))
           		{!! $errors->first('entity_type', '<label class="control-label" for="inputError">:message</label>') !!}
          	@endif
	      </div>
	    </div>
	    <div class="form-group no-mg">
	      <label class="control-label">VAT Repoting Rule</label>
	      <div class="@if($errors->has('vat_reporting_rule')) {{'has-error'}} @endif">
	      	{!! Form::select('vat_reporting_rule', 
	      								[
	      									'' => 'Select Rule', 
	      									'annual' => 'Annual',
	      									'inc' => 'INC',
	      									'6-times-a-year' => '6 times a year',
	      									'not-registered' => 'Not registered'
      									],  $business['vat_reporting_rule'], array('class' => 'form-control')) !!}
	  		@if($errors->has('vat_reporting_rule'))
           		{!! $errors->first('vat_reporting_rule', '<label class="control-label" for="inputError">:message</label>') !!}
          	@endif
	      </div>
	    </div>
	    <div class="form-group no-mg">
	      <label class="control-label">Account Number</label>
	      <div class="@if($errors->has('account_no')) {{'has-error'}} @endif">
	      	{!!Form::text('account_no',$business['account_no'],array('class' => 'form-control'))!!}
	     	@if($errors->has('account_no'))
           		{!! $errors->first('account_no', '<label class="control-label" for="inputError">:message</label>') !!}
          	@endif
	      </div>
	    </div>
	    <div class="form-group no-mg">
	      <label class="control-label">Address</label>
	      <div class="@if($errors->has('address')) {{'has-error'}} @endif">
	      	{!!Form::text('address',$business['address'],array('class' => 'form-control'))!!}  
	     	@if($errors->has('address'))
           		{!! $errors->first('address', '<label class="control-label" for="inputError">:message</label>') !!}
          	@endif
	      </div>
	    </div>
	    <div class="form-group no-mg">
	      <label class="control-label">Potal Code/Town</label>
	      <div class="two-inputs @if($errors->has('postal_code') || $errors->has('town')) {{'has-error'}} @endif">
	      	{!!Form::text('postal_code',$business['postal_code'],array('class' => 'form-control', 'id' => 'postal_code'))!!}  
	      	{!!Form::text('town',$business['town'],array('class' => 'form-control', 'id' => 'city'))!!} 
	     	@if($errors->has('postal_code'))
           		{!! $errors->first('postal_code', '<label class="control-label" for="inputError">:message</label>') !!}
          	@endif
	      	@if($errors->has('town'))
           		{!! $errors->first('town', '<label class="control-label" for="inputError">:message</label>') !!}
          	@endif 
	      </div>
	    </div>
	    <div class="form-group no-mg">
	      <label class="control-label">Country</label>
	      <div class="@if($errors->has('country')) {{'has-error'}} @endif">
	      	{!! Form::select('country', $countries, $business['country'], array('class' => 'full-width form-control')) !!}
			@if($errors->has('country'))
           		{!! $errors->first('country', '<label class="control-label" for="inputError">:message</label>') !!}
          	@endif

	      </div>
	    </div>
	    
	    
	    <div class="form-group no-mg">        
	      <div class="col-sm-offset-2 col-sm-10">
	        <button type="submit" class="btn btn-primary pull-right savebusiness">Save</button>
	      </div>
	    </div>
{!! Form::close() !!}

