@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Expense Details - Applications
@stop

@section('breadcrumb')
    @parent
    <li>Applications</li>
    <li>Expense Details</li>
@stop

@section('content')
    @include('system.application.steps')
    <div class="row">
        @include('flash::message')
        {!!Form::open(['class' => 'form-horizontal'])!!}
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            {{-- Expense Details --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Expense Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <div class='col-md-2 control-label'>{!!Form::label('Any Expense?') !!}</div>
                        <div class='col-md-6'>
                            <label>{!! Form::radio('expense', 1) !!} Yes</label>
                            <label>{!! Form::radio('expense', 0, true) !!} No</label>
                        </div>
                    </div>

                    <div class="expense-details" style="display:none">
                        <div class="new-expense">
                            <h2>Expense <span class="expense-num">1</span> Details</h2>
                            <hr/>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Added this by mistake?') !!}</div>
                                <div class='col-md-6'>
                                    <button type="button" class="btn btn-danger remove-expense">Remove this expense
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class='col-md-2 control-label'>{!!Form::label('Ownership') !!}</div>
                                <div class='col-md-6'>
                                    <select name="applicant_id[]" class="form-control">
                                        @foreach($applicants as $key => $applicant)
                                            <option value="{{$key}}">{{$applicant}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group @if($errors->has('monthly_living_expense')) {{'has-error'}} @endif">
                                <div class='col-md-2 control-label'>{!!Form::label('Monthly Living Expense') !!}</div>
                                <div class='col-md-6'>
                                    <input name="monthly_living_expense[]" class="form-control"/>
                                    @if($errors->has('monthly_living_expense'))
                                        {!! $errors->first('monthly_living_expense', '<label class="control-label"
                                                                                 for="inputError">:message</label>')!!}
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="add-expense-div">
                        <hr/>
                        <div class="form-group">
                            <div class='col-md-2 control-label'>{!!Form::label('Add up to ten expense sources') !!}</div>
                            <div class='col-md-6'>
                                <button type="button" class="btn btn-success add-expense">Add an Expense Source</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer col-lg-12 clear-both">
                    <input type="submit" class="btn btn-primary" value="Next"/>
                </div>
            </div>

        </div>
        {!!Form::close()!!}
    </div>
    {{ EX::js('assets/js/application/expense.js') }}
@stop