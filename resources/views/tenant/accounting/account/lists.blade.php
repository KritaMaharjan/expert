@extends('tenant.layouts.main')

@section('heading')
Accounting List
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body clearfix">
        	<div class="row">        	
	        	<div class="col-md-12 table-responsive">
	        	    @include('flash::message')
	        		<table class="table product-table">
	        			<thead>
	        				<tr>
	        					<th>Lists</th>
	        					
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<tr>
	        					<td><a href="#" data-toggle="modal" data-url="#exp-modal-data" data-target="#fb-modal">Unpaid bill from expense</a></td>
	        				</tr>
	        				<tr>
	        					<td><a href="#" data-toggle="modal" data-url="#collect-modal-data" data-target="#fb-modal">Unpaid bill from collection</a></td>
	        				</tr>
	        			</tbody>
	        		</table>
	        	</div>
			</div>
        </div>
    <div>

<div id="exp-modal-data" class="hide">
	<div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">Register the bill as paid</h3>
        </div>
        <div class="box-body">
		    <form>
		    	<div class="form-group clearfix">
		         	<select class="form-control half-width2 pull-left">
		         		<option>Paid from</option>
		         		<option>Bank account</option>
		         		<option>Cash</option>
		         	</select>
		     	</div>
		     	<br />
		     	<div class="form-group clearfix">
		          {!! Form::label('', 'Amount paid') !!}
		          <input class="form-control date-box" type="text">
		        </div>
				<div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
		          {!! Form::label('due_date', 'Paid date') !!}

		            <div class='input-group date date-box' id='reg-bill-date-picker'>
			            {!! Form:: text('due_date', null, array('class' => 'form-control date-picker', 'id' =>'reg-date-pickers')) !!}
			            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
			            </span>
		            </div>
		        </div><br />
		        <!-- <div class="form-group clearfix">        
			        <div>
			        	<button class="btn btn-primary pull-right savebusiness" type="submit">Register expense</button>
			        </div>
			    </div> -->
		 	</form>
        </div>
    </div>
</div>

<div id="collect-modal-data" class="hide">
	<div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">Loss/Cancel</h3>
        </div>
        <div class="box-body">
      		<div class="row">
      			<div class="col-md-12">
      				<p>
      					This bill qualifies to write off as loss. Do you want to account this as a loss?
      				</p><br />
      				<a href="#" class="btn btn-primary">Account as loss</a>
      				<a href="#" class="btn btn-danger">Cancel - Keep it in the list</a>
      			</div>
      		</div>
        </div>
    </div>
</div>


{{ FB::js('$(function(){
		$("#reg-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });
	})')}}


{{--Load JS--}}
{{FB::registerModal()}}

@stop

