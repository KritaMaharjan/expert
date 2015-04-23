@extends('tenant.layouts.main')

@section('heading')
Accounting List
@stop

@section('content')
<div class="row">    <div class="col-xs-12 mainContainer">
        <div class="box box-solid">
            <div class="box-body clearfix">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        @include('flash::message')
                        <div class="box-body table-responsive">
                            <table id="table-expense" class="table table-hover table-expense">
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Remaining</th>
                                        <th>Billing Date</th>
                                        <th>Payment Due Date</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <table class="table product-table">
                            <thead>
                                <tr>
                                    <th>Lists</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#" data-toggle="modal" data-url="#exp-modal-data" data-target="#fb-modal">Unpaid bill from expense</a></td>
                                </tr>
                                <tr>
                                    <td><a href="#" data-toggle="modal" data-url="#collect-modal-data" data-target="#fb-modal">Unpaid bill from collection</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <div>

        <div id="collect-modal-data" class="hide">
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">Loss/Cancel</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                This bill qualifies to write off as loss. Do you want to account this as a loss?
                            </p><br />
                            <a href="#" class="btn btn-primary">Account as loss</a>
                            <a href="#" class="btn btn-danger">Cancel - Keep it in the list</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>

{{--Load JS--}}
{{ FB::registerModal() }}
{{ FB::js('assets/js/expense-list.js') }}

@stop

