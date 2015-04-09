@extends('tenant.layouts.main')

@section('heading')
Accounting Setup
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
                <h5>Open/Close accounting year</h5>
                <div class="box-body">
                	<div class="btns-box">
	                	<a href="#" class="btn btn-primary">
	                		Migration from previous accounts
	                	</a>
	                	<a href="http://demo.mashbooks.app/accounting/new-business" class="btn btn-warning">
	                		This is a new business - I have no previous accounts
	                	</a>
	                </div>
                </div>
        </div>
    <div>
@stop