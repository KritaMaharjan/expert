@extends('tenant.layouts.main')

@section('heading')
Utlegg Follow Up
@stop

@section('content')
    <div class="box box-solid">
        <div class="box-body">
        	<div class="box-header pad-0">
                <h3 class="box-title"></h3>
            </div>

            <div class="row">
        	</div>
        </div>
    </div>


{{--Load JS--}}
{{FB::registerModal()}}

@stop