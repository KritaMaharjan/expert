@extends('tenant.layouts.main')

@section('heading')
VAT ADMINISTRATION
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
            @include('flash::message')
            <div class="row">
            	<div class="col-md-6">
            		<form>
		        		<div class="form-group clearfix">
				         	<select class="form-control half-width2 pull-left" name="year" id="year">
				         		<option value="">Select year</option>
				         		<option value="2015">2015</option>
				         		<option value="2016">2016</option>
				         	</select>
							<div class="date-box">					         	
					         	<select class="form-control" name="period" id="period">
					         		<option value="">Select VAT period</option>
					         		<option value="1">Term 1 (Jan-Feb)</option>
					         		<option value="2">Term 2 (Mar-Apr)</option>
					         		<option value="3">Term 3 (May-Jun)</option>
					         		<option value="4">Term 4 (Jul-Aug)</option>
					         		<option value="5">Term 5 (Sept-Oct)</option>
					         		<option value="6">Term 6 (Nov-Dec)</option>
					         	</select>					         	
				         	</div>
				        </div>
				       
		            </form>
            	</div>            	
            </div>
            <div class="row">
	        	<div class="col-md-12 table-responsive entries-info">

	        	</div>
        	</div>
        </div>
    </div>
    {{ FB::js('assets/js/vat.js') }}
@stop