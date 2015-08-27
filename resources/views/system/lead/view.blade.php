@extends('system.layouts.main')

<?php $type = Request::segment(2); ?>
@section('heading')
    Leads
@stop

@section('breadcrumb')
    @parent
    <li>Leads</li>
    <li>View</li>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 mainContainer">
            @include('flash::message')
            <div class="box box-solid">
                <div class="box-body table-responsive">
                    <table id="table-lead" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Added On</th>
                            <th>Sales Team Assigned</th>
                            <th>Lead Received</th>
                            <th>Loan Submission</th>
                            <th>Loan Settlement</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{format_datetime($lead_details->created_at)}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            {{-- Customer Details --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Customer Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="title-sm"> Preferred Name :</div> {{$lead_details->preferred_name}}
                            </div>
                            <div class="col-md-6">
                                <div class="title-sm"> Given Name :</div> {{$lead_details->given_name}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="title-sm"> Last Name :</div> {{$lead_details->surname}}
                            </div>
                            <div class="col-md-6">
                                <div class="title-sm"> Email :</div> {{$lead_details->email}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Loan Details --}}
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Loan Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="title-sm"> Loan Amount :</div> {{$lead_details->amount}}
                            </div>
                            <div class="col-md-6">
                                <div class="title-sm"> Loan Type :</div> {{$lead_details->loan_type}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="title-sm"> Loan Purpose :</div> {{$lead_details->loan_purpose}}
                            </div>
                            <div class="col-md-6">
                                <div class="title-sm"> Property Search :</div> {{$lead_details->property_search_area}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="title-sm"> Area :</div> {{$lead_details->area}}
                            </div>
                            <div class="col-md-6">
                                <div class="title-sm"> Bank :</div> {{$lead_details->bank_name}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="title-sm"> Interest Rate :</div> {{$lead_details->interest_rate}}
                            </div>
                            <div class="col-md-6">
                                <div class="title-sm"> Interest Type:</div> {{config('general.interest_type')[$lead_details->interest_type]}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="title-sm"> Interest Till Date :</div> {{format_datetime($lead_details->interest_date_till)}}
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lead Details --}}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Lead Details</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title-sm"> Referral Notes :</div> <br/>
                                {{$lead_details->referral_notes}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title-sm"> Feedbacks :</div><br/>
                                {{$lead_details->feedback}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($lead_details->status == 0)
                <div class="box-footer col-lg-12 clear-both">
                    <a href="{{route('system.lead.assign', $lead_details->id)}}" class="btn btn-primary">Assign Lead</a>
                </div>
            @endif
        </div>
    </div>

@stop