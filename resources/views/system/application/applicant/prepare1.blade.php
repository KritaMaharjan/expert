@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Prepare Applications
@stop

@section('breadcrumb')
    @parent
    <li>Applications</li>
    <li>Prepare</li>
@stop

@section('content')
    @include('system.application.steps')

    <div class="row">
        {!!Form::open(['class' => 'form-horizontal'])!!}
        <div class="col-xs-12 mainContainer">
            @include('flash::message')

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">Applicants</h3>
                </div>

                <div class="box-body applicant-details">
                    {{-- Already added applicants --}}
                    @foreach($applicants as $app_key => $applicant)
                        @include('system.application.applicant.editApplicant')
                    @endforeach

                    @if($total_applicants < 10)
                        @include('system.application.applicant.newApplicant')
                    @endif

                    <div class="add-applicant-div" {{($total_applicants < 9)? '' : 'style="display: none;"'}}>
                        <hr/>
                        <div class="form-group">
                            <div class='col-md-2 control-label'>{!!Form::label('Add up to ten applicants') !!}</div>
                            <div class='col-md-6'>
                                <button type="button" class="btn btn-success add-applicant">Add an Applicant</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="submit" class="btn btn-primary" value="Next" name="submit"/>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
    {{ EX::js('assets/js/application/prepare.js') }}
@stop