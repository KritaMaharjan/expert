@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Properties - Applications
@stop

@section('breadcrumb')
    @parent
    <li>Applications</li>
    <li>Properties</li>
@stop

@section('content')

    @include('system.application.steps')
    <div class="row">
        @include('flash::message')
        {!!Form::open(['class' => 'form-horizontal'])!!}
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Properties</h3>
                </div>

                <div class="box-body property-details">
                    {{-- Already added applicants --}}
                    @foreach($properties as $prop_key => $property)
                        @include('system.application.property.edit')
                    @endforeach

                    @if($total_properties < 10)
                        @include('system.application.property.new')
                    @endif

                    <div class="add-property-div">
                        <hr/>
                        <div class="form-group">
                            <div class='col-md-2 control-label'>{!!Form::label('Add up to ten properties') !!}</div>
                            <div class='col-md-6'>
                                <button type="button" class="btn btn-success add-property">Add an Property
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer col-lg-12 clear-both">
                    <input type="submit" class="btn btn-primary" value="Next" name="submit"/>
                </div>
            </div>

        </div>
        {!!Form::close()!!}
    </div>
    {{ EX::js('assets/js/application/property.js') }}
@stop