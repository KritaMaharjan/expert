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
            		{!!Form::open(['id'=>'expense-form', 'enctype'=>'multipart/form-data', 'files'=>true])!!}
		            	<div class="form-group clearfix">
		            	    {!! Form::select('type', ['supplier' => 'From supplier', 'cash' => 'Cash purchase'], null, array('class' => 'form-control half-width2 pull-left source', 'id' => 'source')) !!}
							<div class="date-box supplier">
					         	<select name="supplier_id" class="form-control select-supplier">
					         		<option value="">Select supplier</option>
					         	</select>
					         	<p class="align-right pad-top-10">
                                    <a class="btn btn-default btn-small" id="supplier-add" data-toggle="modal" data-url="#supplier-modal-data" data-target="#fb-modal">
                                         New
                                    </a>
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
				          {!! Form:: text('invoice_number', null, array('class' => 'form-control date-box')) !!}
				        </div>
				       
		            </form>
            	</div>
            	<div class="col-md-6">
            		<div class="image-section">
            			<!-- <img src="../../assets/images/print.jpg"> -->

            			<h4>Drop files anywhere to upload</h4>
            				<span>or</span>
            					<input type="file" class="upload-file">
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
	        					<td>
	        					    {!! Form:: text('text[]', null, array('class' => 'form-control')) !!}
                                </td>
	        					<td>
	        					    {!! Form:: text('amount[]', null, array('class' => 'form-control')) !!}
	        					</td>
	        					<td>
                                    {!! Form::select('vat[]', $tax, null, array('class' => 'form-control', 'id' => 'vat')) !!}
	    						</td>
	        					<td>
	        					    {!! Form:: text('total[]', null, array('class' => 'form-control')) !!}
                                </td>
	        					<td>
	        					    {!! Form::select('account_code_id[]', $accounts, null, array('class' => 'select-multiple', 'id' => 'account-code')) !!}
	        					</td>
	        				</tr>
	        			</tbody>
	        		</table>
	        		<span class="btn-table-bottom">
                        <a title="Add a product" class="add-btn btn btn-success" href="javascript:;"><i class="fa fa-plus"></i> Add a product</a>
                    </span>
	        	</div>
	        	<div class="col-md-12">
	        		<form>
	        			<div class="form-group">
	        				<label id="paid-box"><input type="checkbox" class="icheck"> &nbsp;&nbsp;The bill is already paid.</label>
	        			</div>

	        			<div class="row">
	        				<div id="after-paid" class="col-md-6">
                                <div class="form-group clearfix">
                                    Paid from
                                    {!! Form::select('payment_method', [1 => 'Cash', 2 =>'Bank account'] , null, array('class' => 'form-control half-width2 pull-left')) !!}
                                </div>
                                <br />
                                <div class="form-group clearfix">
                                    {!! Form::label('', 'Amount paid') !!}
                                    {!! Form:: text('amount_paid', null, array('class' => 'form-control date-box')) !!}
                                </div>
                                <div class="form-group clearfix {{ ($errors->has('due_date'))? 'has-error': '' }}">
                                    {!! Form::label('due_date', 'Paid date') !!}

                                    <div class='input-group date date-box' id='due-date-picker'>
                                        {!! Form:: text('due_date', null, array('class' => 'form-control', 'id' =>'paid-date-pickers')) !!}
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div><br />
		        			</div>
	        			</div>

	        			<div class="form-group clearfix">
                            <div>
                                <button class="btn btn-primary pull-right savebusiness" type="submit">Register expense</button>
                            </div>
                        </div>
	        		{!! Form::close() !!}
	        	</div>
        	</div>
        </div>
    <div>

    <div id="supplier-modal-data" class="hide">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Add New Supplier</h3>
            </div>
            @include('tenant.supplier.createSupplier')
        </div><!-- /.box-body -->
    </div>

    {{FB::registerModal()}}
    {{ FB::js('assets/js/expense.js') }}
</div>
</div>
@stop