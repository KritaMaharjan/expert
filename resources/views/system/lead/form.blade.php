<div class="row">
    @if(isset($lead))
        {!!Form::model($lead)!!}
    @else
        {!!Form::open()!!}
    @endif

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
        {{--<a class="btn btn-primary" data-toggle="modal" data-url="#client-modal-data" data-target="#ex-modal">
            Add new Client
        </a>--}}
        <a class="btn btn-primary add-client">
            Add new Client
        </a>
        <br/>
        <br/>
        <div class="client-box" style="{{(count($errors) > 0)? '' : 'display: none'}}">
            @include('system.lead.clientform')
        </div>
        <div class="client-info" style="display: none">
        </div>

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
                    <div class='col-md-6'>
                        <div class="form-group">
                            {!!Form::label('Loan Purpose') !!}
                            {!!Form::select('loan_purpose', config('general.loan_purpose'), null, array('class' =>
                            'form-control'))!!}
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-12'>
                        <div class="form-group @if($errors->has('referral_notes')) {{'has-error'}} @endif">
                            {!!Form::label('Referral Notes') !!}
                            {!!Form::textarea('referral_notes', null, array('class' => 'form-control'))!!}
                            @if($errors->has('referral_notes'))
                                {!! $errors->first('referral_notes', '<label class="control-label"
                                                                             for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <input name="submit" type="submit" class="btn btn-primary pull-left" value="Submit"/>
            </div>
        </div>
        <!-- /.box -->
    </div>
    {!!Form::close()!!}
</div>

{{-- Add new client modal --}}
{{ EX::js("$('.date-picker').datepicker({format: 'yyyy-mm-dd', startDate: new Date()});") }}
{{ EX::js('assets/js/lead/create-lead.js') }}

{{--Load JS--}}
{{EX::registerModal()}}