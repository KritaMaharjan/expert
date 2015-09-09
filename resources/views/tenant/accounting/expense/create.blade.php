@extends('tenant.layouts.main')

@section('heading')
Accounting Expenses
@stop
@section('breadcrumb')
    @parent
    <li>Accounting</li>
    <li>Create Expenses</li>
@stop
@section('content')
    <div class="box box-solid">
        <div class="box-body">
        	<div class="box-header pad-0">
                <h3 class="box-title"></h3>
            </div>

            {!!Form::open(['id'=>'expense-form', 'enctype'=>'multipart/form-data', 'files'=>true])!!}
                @include('tenant.accounting.expense.form')
        	{!! Form::close() !!}
        </div>
    <div>

    <div id="supplier-modal-data" class="hide">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Add New Supplier</h3>
            </div>
            @include('tenant.supplier.createSupplier')
        </div><!-- /.box-body -->
    </div>

    {{ FB::registerModal() }}
    {{ FB::js('assets/js/expense.js') }}
</div>
</div>
@stop