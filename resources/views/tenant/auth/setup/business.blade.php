@extends('tenant.layouts.min')

@section('content')
<link href="http://manish1.mashbooks.no/assets/plugins/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="http://manish1.mashbooks.no/assets/plugins/jquery-ui-1.11.4.custom/jquery-ui.js" type="text/javascript"></script>
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
					      	{!!Form::text('postal_code','',array('class' => 'form-control postal_code', 'id' => 'postal_code'))!!}  
					      	{!!Form::text('town','',array('class' => 'form-control city', 'id' => 'city'))!!} 
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
{{ FB::js('
  var app_url = "http://pooja.mashbooks.no/manish_co/";
	 var cache = {};
    $(".postal_code")
        .bind("keydown", function (event) {
            if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 0,
            source: function(request, response) {
              requestURL =  appUrl+"postal/suggestions";
                
              var term = request.term;
                if (term in cache) {
                    response(cache[term]);
                    return;
                }
                $.getJSON(requestURL, {term: request.term}, function (data, status, xhr) {
                   cache[ term ] = data;
                         items1 = $.map(data, function(item) {

                            return   {label: item.postcode +" , " +item.town ,
                                value: item.postcode,
                                town :item.town ,
                                id: item.id}


                        });

                        response(items1);
                });
            },
             //appendTo: "#customer-modal-data",
            search: function(event, ui) {
               
            },
            response: function(event, ui) {
               
            },
            create: function(event, ui) {
            },
            open: function(event, ui) {
               
            },
            focus: function(event, ui) {

            },
            _resizeMenu: function() {
                this.menu.element.outerWidth(200);
            },
            select: function(event, ui) {
                
                 var label = ui.item.town;
                 
                $(".city").val(label);
            }
        });')}}
@stop