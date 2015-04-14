@extends('tenant.layouts.main')

@section('heading')
Purring
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
        	<div class="box-header pad-0">
                <h3 class="box-title">Purring</h3>
            </div>

            <div class="row">
            	<div class="col-md-6">
            		<p><a href="#" class="btn btn-default">Create a Purring.pdf</a></p>
            		<p><a href="#" class="">Skip this step</a></p>
            		<p><a href="#" class="btn btn-primary">Register payment</a></p>
            		<p><a href="#" class="btn btn-primary">Register dispute</a></p>
            		<p><a href="#" class="btn btn-danger">Cancel collection case</a></p>
            	</div>
        	</div>
        </div>
    </div>


{{--Load JS--}}
{{FB::registerModal()}}

@stop