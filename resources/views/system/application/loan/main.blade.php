@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Loans - Applications
@stop

@section('breadcrumb')
    @parent
    <li>Applications</li>
    <li>Loans</li>
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
                    <h3 class="box-title">Loans</h3>
                </div>
                <div class="box-body loan-details">
                    @include('system.application.loan.'.$action)
                    <div class="add-loan-div" {{($total_loans < 9)? '' : 'style="display: none;"'}}>
                        <hr/>
                        <div class="form-group">
                            <div class='col-md-2 control-label'>{!!Form::label('Add up to ten properties') !!}</div>
                            <div class='col-md-6'>
                                <button type="button" class="btn btn-success add-loan">Add an Loan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    {!!Form::submit('Add Loan', ['class' => 'btn btn-primary'])!!}
                </div>
            </div>

        </div>
        {!!Form::close()!!}
    </div>
    {{ EX::js('assets/js/application/loan.js') }}
@stop