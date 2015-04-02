@extends('tenant.layouts.main')

@section('heading')
VAT
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
        	<div class="box-header pad-0">
                <h3 class="box-title">VAT <font class="uppercase">administration</font></h3>
            </div>
            <div class="row mg-btm-40">
            	<div class="col-md-6">
            		<form>
		            	
		        		<div class="form-group clearfix">
				         	<select class="form-control half-width2 pull-left">
				         		<option>Select year</option>
				         		<option>2015</option>
				         		<option>2016</option>
				         	</select>
							<div class="date-box">					         	
					         	<select class="form-control">
					         		<option>Select VAT period</option>
					         		<option>Term 1 (Jan-Feb)</option>
					         		<option>Term 2 (Mar-Apr)</option>
					         		<option>Term 3 (May-Jun)</option>
					         		<option>Term 4 (Jul-Aug)</option>
					         		<option>Term 5 (Sept-Oct)</option>
					         		<option>Term 6 (Nov-Dec)</option>
					         	</select>					         	
				         	</div>
				        </div>
				       
		            </form>
            	</div>            	
            </div>
            <div class="row">
            	<div class="col-md-12">
            		<p><strong>Based on the year and term above display information as such:</strong></p>
            	</div>
	        	<div class="col-md-12 table-responsive">
	        		<table class="table table-striped product-table">	        			
	        			<tbody>
	        				<tr>
	        					<td>Post 1</td>
	        					<td>Total VAT <font class="uppercase">billed</font> (total amount in accounts 3000-3090 + 3200+3280)</td>	        					
	        				</tr>
	        				<tr>
	        					<td>Post 2</td>
	        					<td>Sum of post 3, post 4, post 5, post 6. (the amounts without the VAT included)</td>	        					
	        				</tr>
	        				<tr>
	        					<td>Post 3</td>
	        					<td>Total Exempt VAT, (Total amount in accounts 3100)</td>	        					
	        				</tr>
	        				<tr>
	        					<td>Post 4</td>
	        					<td>Total high VAT: (Total amount in accounts 3000-3020)</td>	        					
	        				</tr>
	        				<tr>
	        					<td>Post 5</td>
	        					<td>Total medium VAT: (Total amount in accounts 3030-3040)</td>	        					
	        				</tr>
	        				<tr>
	        					<td>Post 6</td>
	        					<td>Total low VAT: (Total amount in accounts 3050)</td>	        					
	        				</tr>
	        				<tr>
	        					<td>Post 7</td>
	        					<td>Total export VAT: (Total amount in accounts 3200-3280)</td>	        					
	        				</tr>
	        				<tr>
	        					<td>Post 8</td>
	        					<td>Total high VAT: (when expenses with VAT is paid: (total of account 2711))</td>	        					
	        				</tr>
	        				<tr>
	        					<td>Post 9</td>
	        					<td>Paid medium VAT: (total of account 2713)</td>	        					
	        				</tr>
	        				<tr>
	        					<td>Post 10</td>
	        					<td>Paid low VAT: (Total of account 2714)</td>	        					
	        				</tr>
	        			</tbody>
	        		</table>
	        	</div>
	        	
        	</div>
        </div>
    <div>
    {{ FB::js('$(function(){
		$("#billing-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
        });
       
	})')}}
@stop