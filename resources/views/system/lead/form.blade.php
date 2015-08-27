<div class="row">
    {!!Form::open()!!}
    <div class="col-md-12">

        <div class="form-group @if($errors->has('ex_clients_id')) {{'has-error'}} @endif">
            {!!Form::label('Select Client') !!}
            {!!Form::select('ex_clients_id', $clients, null, array('class' => 'form-control', 'id' => 'client-select'))!!}
            @if($errors->has('ex_clients_id'))
                {!! $errors->first('ex_clients_id', '<label class="control-label"
                                                            for="inputError">:message</label>') !!}
            @endif
        </div>
        <h3>OR</h3>
        <a class="btn btn-primary" data-toggle="modal" data-url="#client-modal-data" data-target="#ex-modal">
            Add new Client
        </a>
        <br/>
        <br/>

        <!-- loan details-->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Loan Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div class='row'>
                    <div class='col-md-6'>
                        <div class="form-group">
                            {!!Form::label('Loan Type') !!}
                            {!!Form::select('loan_type', config('general.loan_type'), null, array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('property_search_area')) {{'has-error'}} @endif">
                            {!!Form::label('Property Search') !!}
                            {!!Form::text('property_search_area','',array('class' => 'form-control'))!!}
                            @if($errors->has('property_search_area'))
                                {!! $errors->first('property_search_area', '<label class="control-label"
                                                                                   for="inputError">:message</label>')
                                !!}
                            @endif
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-6'>
                        <div class="form-group">
                            {!!Form::label('Loan Purpose') !!}
                            {!!Form::select('loan_purpose', config('general.loan_purpose'), null, array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('bank_name')) {{'has-error'}} @endif">
                            {!!Form::label('Bank') !!}
                            {!!Form::text('bank_name','',array('class' => 'form-control'))!!}
                            @if($errors->has('bank_name'))
                                {!! $errors->first('bank_name', '<label class="control-label"
                                                                        for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('area')) {{'has-error'}} @endif">
                            {!!Form::label('Area') !!}
                            {!!Form::text('area','',array('class' => 'form-control'))!!}
                            @if($errors->has('area'))
                                {!! $errors->first('area', '<label class="control-label"
                                                                   for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Interest Type') !!}
                            <div class="form-group">
                                <div class="radio">
                                    <label>
                                        {!!Form::radio('interest_type', 1, true);!!}
                                        Variable
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        {!!Form::radio('interest_type', 0);!!}
                                        Fixed
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-6'>
                        <div class="form-group @if($errors->has('interest_rate')) {{'has-error'}} @endif">
                            {!!Form::label('Interest Rate %') !!}
                            {!!Form::text('interest_rate','',array('class' => 'form-control'))!!}
                            @if($errors->has('interest_rate'))
                                {!! $errors->first('interest_rate', '<label class="control-label"
                                                                            for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group clearfix {{ ($errors->has('interest_date_till'))? 'has-error': '' }}">
                            {!! Form::label('Interest Till') !!}
                            <div id="due_date" class="input-group date">
                                {!! Form:: text('interest_date_till', null, array('class' => 'form-control date-picker')) !!}
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                            @if($errors->has('interest_date_till'))
                                {!! $errors->first('interest_date_till', '<label class="control-label"
                                                                                 for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('amount')) {{'has-error'}} @endif">
                            {!!Form::label('Amount') !!}
                            {!!Form::text('amount','',array('class' => 'form-control'))!!}
                            @if($errors->has('amount'))
                                {!! $errors->first('amount', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{--<div class="box-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>--}}
        </div>
        <!-- /.box -->

        <!-- lead details-->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Lead Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="form-group @if($errors->has('referral_notes')) {{'has-error'}} @endif">
                    {!!Form::label('Referral Notes') !!}
                    {!!Form::textarea('referral_notes','',array('class' => 'form-control'))!!}
                    @if($errors->has('referral_notes'))
                        {!! $errors->first('referral_notes', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                    @endif
                </div>
                <div class="form-group @if($errors->has('feedback')) {{'has-error'}} @endif">
                    {!!Form::label('Feedbacks') !!}
                    {!!Form::textarea('feedback','',array('class' => 'form-control'))!!}
                    @if($errors->has('feedback'))
                        {!! $errors->first('feedback', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                    @endif
                </div>
            </div>
            <div class="box-footer">
                <input name="submit" type="submit" class="btn btn-primary pull-left" value="Submit"/>
                {{--<a class="btn btn-success pull-left">Submit</a>--}}
                <input name="assign" type="submit" class="btn btn-primary pull-right" value="Submit and Assign Lead"/>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>

{{-- Add new client modal --}}
<div id="client-modal-data" class="hide">
    <div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">Add New Client</h3>
        </div>
        <div class="row mainContainer">
            <div class="col-xs-12">
                {!!Form::open(['id' => 'client-form'])!!}
                @include('system.lead.clientform')
                <div class="box-footer col-lg-12 clear-both">
                    <input type="submit" class="btn btn-primary client-submit" value="Add Client"/>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
{{ EX::js("$('.date-picker').datepicker({format: 'yyyy-mm-dd', startDate: new Date()});") }}
{{ EX::js('assets/js/lead/create-lead.js') }}

{{--Load JS--}}
{{EX::registerModal()}}