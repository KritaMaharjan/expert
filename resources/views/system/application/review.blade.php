@extends('system.layouts.main')
@section('heading')
    Review - Application
@stop

@section('breadcrumb')
    @parent
    <li>Applications</li>
    <li>Review</li>
@stop

@section('content')
    @include('system.application.steps')
    <div class="row">
        @include('flash::message')
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            {{-- Expense Details --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Review Your Application</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <p>
                        Please find below a summary of the details you have provided. If you wish to
                        make any changes, you can easily do so by selecting the "edit" links on the
                        right hand side of the page.
                    </p>

                    @include('system.application.review.applicantReview')
                    @include('system.application.review.propertyReview')
                    @include('system.application.review.otherReview')
                    @include('system.application.review.incomeReview')
                    @include('system.application.review.expenseReview')
                </div>
            </div>

        </div>
    </div>
@stop