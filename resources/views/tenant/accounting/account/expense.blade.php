@extends('tenant.layouts.main')

@section('heading')
Accounting Expenses
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
        	<div class="box-header pad-0">
                <h3 class="box-title">Accounting expenses</h3>
            </div>
            <div class="row mg-btm-40">
            	<div class="col-md-6">
            		<form>
		            	<div class="form-group clearfix">
				         	<select class="form-control half-width2 pull-left">
				         		<option>From supplier</option>
				         		<option>Cash purchase</option>
				         	</select>
							<div class="date-box">					         	
					         	<select class="form-control">
					         		<option>Select supplier</option>
					         	</select>
					         	<p class="align-right pad-top-10">
					         	<a href="#" class="btn btn-default btn-small">New</a>
					         	</p>

				         	</div>
				        </div>
		        		<div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
				          {!! Form::label('due_date', 'Billing date') !!}

				          <div class='input-group date date-box' id='due-date-picker'>
				              {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'billing-date-pickers')) !!}
				              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
				              </span>
				          </div>

				        </div>
				        <div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
				          {!! Form::label('due_date', 'Payment due date') !!}

				          <div class='input-group date date-box' id='due-date-picker'>
				              {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'payment-date-pickers')) !!}
				              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
				              </span>
				          </div>

				        </div>
				        <div class="form-group clearfix">
				          {!! Form::label('', 'Invoice number') !!}
				          <input class="form-control date-box" type="text">
				        </div>
				       
		            </form>
            	</div>
            	<div class="col-md-6">
            		<div class="image-section">
            			<!-- <img src="../../assets/images/print.jpg"> -->

            			<h4>Drop files anywhere to upload</h4>
            				<span>or</span>
            				<form class="upload-file">
            					<input type="file">	
            				</form>
            				<br />
            				<span>Maximum upload file size: 20MB</span>
            		</div>
            	</div>
            </div>
            <div class="row">
	        	<div class="col-md-12 table-responsive">
	        		<table class="table product-table">
	        			<thead>
	        				<tr>
	        					<th width="30%">Text</th>
	        					<th width="10%">Amount</th>
	        					<th width="20%">VAT</th>
	        					<th width="10%">Total amount</th>
	        					<th width="30%">Expense account</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<tr>
	        					<td><!-- <span class="border-bx block price"> </span> --><input type="text" class="form-control"></td>
	        					<td><input type="text" class="form-control"></td>
	        					<td>
	        						<select class="form-control">
	        							<option>VAT</option>
	        							<option>8%</option>
	        							<option>15%</option>
	        							<option>25%</option>
	        							<option>Foreign Exempt</option>
	        							<option>Domestic Exempt</option>
	        						</select>
	    						</td>
	        					<td><input type="text" class="form-control"></td>
	        					<td>
	        						<select class="select-multiple">
										<option>Select expense account</option>
	        							<optgroup label="40 Forbruk av ravarer og innkjopte halvfabrilater">
											<option>4000 Innkjop av ravarer og halvfabrikata hoy sats</option>
											<option>4030 Innkjop av ravarer og halvfabrikata middels sats</option>
											<option>4060 Frakt, toll og spedisjon  </option>
											<option>4070 Innkjopsprisreduksjon</option>
											<option>4090 Beholdningsendering</option>
										</optgroup>
	        						</select>
	        					</td>
	        				</tr>
	        			</tbody>
	        		</table>
	        	</div>
	        	<div class="col-md-12">
	        		<form>
	        			<div class="form-group">
	        				<label id="paid-box"><input type="checkbox" class="icheck"> &nbsp;&nbsp;The bill is already paid.</label>
	        			</div>

	        			<div class="row">
	        				<div id="after-paid" class="col-md-6">
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

							            <div class='input-group date date-box' id='due-date-picker'>
								            {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'paid-date-pickers')) !!}
								            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
								            </span>
							            </div>
							        </div><br />
							        <div class="form-group clearfix">        
								        <div>
								        	<button class="btn btn-primary pull-right savebusiness" type="submit">Register expense</button>
								        </div>
								    </div>
					         	</form>
		        			</div>
	        			</div>
	        		</form>
	        	</div>
        	</div>
        </div>
    <div>
    {{ FB::js('$(function(){
		$("#billing-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });
        $("#payment-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });
        $("#paid-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });
        $(".select-multiple").select2({
			theme: "classic"
		});

		$("#paid-box").on("click",function(){
			$("#after-paid").slideToggle();
		});


	})')}}
@stop