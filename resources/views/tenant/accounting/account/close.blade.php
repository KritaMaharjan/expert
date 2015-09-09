@extends('tenant.layouts.main')

@section('heading')
VAT
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
        	<div class="box-header pad-0">
                <h3 class="box-title">Close Accounting Year</font></h3>
            </div>
            
            <div class="row">
	        	<div class="col-md-12 table-responsive">
	        		<table class="table product-table">	        			
	        			<tbody>
	        				<tr>
	        					<td>2015</td>
	        					<td>Open - <a href="#" data-toggle="modal" data-url="#close-ac-modal-data" data-target="#fb-modal" class="to-close" title="Close this one">Close this one</a></td>	        					
	        				</tr>
	        				<tr>
	        					<td>2014</td>
	        					<td><font class="uppercase">Closed</font></td>	        					
	        				</tr>
	        				
	        			</tbody>
	        		</table>
	        	</div>
	        	
        	</div>
        </div>
    <div>

<div id="close-ac-modal-data" class="hide">
	<div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">Close Accounting Year</h3>
        </div>
        <div class="box-body">
      		<div class="row">
      			<div class="col-md-12">
      				<p>
      					Check that the balance of accounts 1000-2999 = <strong>0</strong>
      				</p>
      				<p>
      					Check that the balance of accounts 3000-8999 = <strong>0</strong>
      				</p>
      				<p>
      					Check that all <strong>VAT <font class="uppercase">reports for the year has status sent</font></strong>
      				</p>
      				<br />
      				<p class="align-right">
      					<a href="#" class="btn btn-danger">Close Accounting Year</a>
      				</p>
      			</div>
      		</div>
        </div>
    </div>
</div>


{{--Load JS--}}
{{FB::registerModal()}}

@stop