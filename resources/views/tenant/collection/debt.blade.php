@extends('tenant.layouts.main')

@section('heading')
Debt Forecast
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
        	<div class="box-header pad-0">
                <h3 class="box-title">Debt Forecast</h3>
            </div>

            <div class="row">
            	<div class="col-md-6">
            		<p><a href="#" class="btn btn-default" title="Create a Debt.pdf">Create a Debt.pdf</a></p>
            		<p><a href="#" class="btn btn-primary" title="Register payment">Register payment</a></p>
            		<p><a href="#" class="btn btn-primary" title="Register dispute">Register dispute</a></p>
            		<p><a href="#" class="btn btn-danger" title="Cancel collection case">Cancel collection case</a></p>
            	</div>
        	</div>
        </div>
    </div>


{{--Load JS--}}
{{FB::registerModal()}}

@stop