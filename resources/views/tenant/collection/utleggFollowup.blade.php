@extends('tenant.layouts.main')

@section('heading')
Utlegg Follow Up
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
        	<div class="box-header pad-0">
                <h3 class="box-title">Follow up on your "utlegg" case:</h3>
            </div>

            <div class="row">
            	<div class="col-md-6">
            		<p><a href="#" class="btn btn-primary">Register payment</a></p>
            		<p><a href="#" class="btn btn-primary">No money awarded</a></p>
            		<p><a href="#" class="btn btn-primary">Case is now disputed</a></p>
            		<p><a href="#" class="btn btn-danger">Cancel collection case</a></p>
            	</div>
        	</div>
        </div>
    </div>


{{--Load JS--}}
{{FB::registerModal()}}

@stop