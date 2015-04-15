@extends('tenant.layouts.main')

@section('heading')
Options
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
        	<!-- <div class="box-header pad-0">
                <h3 class="box-title"></h3>
            </div> -->

            <div class="row">
            	<div class="col-md-6">
            		<p><a href="#" class="btn btn-primary" title="Take the case to court">Take the case to court</a></p>
            		<p><a href="#" title="or skip the step and go to">or skip the step and go to</a></p>
            		<p><a href="#" class="btn btn-default" title="Create Utlegg.pdf">Create Utlegg.pdf</a></p>
            	</div>
        	</div>
        </div>
    </div>


{{--Load JS--}}
{{FB::registerModal()}}

@stop