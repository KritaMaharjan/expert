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
                            <label><input type="radio" name="expense" value=1 {{($action == 'edit')? 'checked=checked':''}}>Yes</label>
                            <label><input type="radio" name="expense" value=0 {{($action == 'add')? 'checked=checked':''}}>No</label>
                        </div>
                    </div>

                    <div class="expense-details" style="{{($action == 'edit')? '' : 'display:none'}}">
                        @include('system.application.expense.'.$action)
                        {!!Form::hidden('action', $action)!!}

                    <div class="add-expense-div" {{($total_expenses < 9)? '' : 'style="display: none;"'}}>
                        <hr/>
                        <div class="form-group">
                            <div class='col-md-2 control-label'>{!!Form::label('Add up to ten expense sources') !!}</div>
                            <div class='col-md-6'>
                                <button type="button" class="btn btn-success add-expense">Add an Expense Source</button>
                            </div>
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