<div class="box-header with-border">
    <h3 class="box-title">Lender Details</h3>
</div>
<!-- /.box-header -->
<div class="box-body">
    <div class="form-group @if($errors->has('company_name')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('Company Name') !!}</div>
        <div class='col-md-6'>
            {!!Form::text('company_name', null, array('class' => 'form-control', 'id'=>'company_name'))!!}
            @if($errors->has('company_name'))
                {!! $errors->first('company_name', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('contact_name')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('Contact Name') !!}</div>
        <div class='col-md-6'>
            {!!Form::text('contact_name', null, array('class' => 'form-control', 'id'=>'contact_name'))!!}
            @if($errors->has('contact_name'))
                {!! $errors->first('contact_name', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('job_title')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('Job Title') !!}</div>
        <div class='col-md-6'>
            {!!Form::text('job_title', null, array('class' => 'form-control', 'id'=>'job_title'))!!}
            @if($errors->has('job_title'))
                {!! $errors->first('job_title', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('title')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('Title') !!}</div>
        <div class='col-md-6'>
            {!!Form::text('title', null, array('class' => 'form-control', 'id'=>'title'))!!}
            @if($errors->has('title'))
                {!! $errors->first('title', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('preferred_name')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('Preferred Name') !!}</div>
        <div class='col-md-6'>
            {!!Form::text('preferred_name', null, array('class' => 'form-control', 'id'=>'preferred_name'))!!}
            @if($errors->has('preferred_name'))
                {!! $errors->first('preferred_name', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('first_name')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('First Name') !!}</div>
        <div class='col-md-6'>
            {!!Form::text('first_name', null, array('class' => 'form-control', 'id'=>'first_name'))!!}
            @if($errors->has('first_name'))
                {!! $errors->first('first_name', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('last_name')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('Last Name') !!}</div>
        <div class='col-md-6'>
            {!!Form::text('last_name', null, array('class' => 'form-control', 'id'=>'last_name'))!!}
            @if($errors->has('last_name'))
                {!! $errors->first('last_name', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('phone')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('Phone Number') !!}</div>
        <div class='col-md-6'>
            {!!Form::text('phone', null, array('class' => 'form-control', 'id'=>'phone'))!!}
            @if($errors->has('phone'))
                {!! $errors->first('phone', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('email')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('Email') !!}</div>
        <div class='col-md-6'>
            {!!Form::text('email', null, array('class' => 'form-control', 'id'=>'email'))!!}
            @if($errors->has('email'))
                {!! $errors->first('email', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('abn')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('ABN') !!}</div>
        <div class='col-md-6'>
            {!!Form::text('abn', null, array('class' => 'form-control', 'id'=>'abn'))!!}
            @if($errors->has('abn'))
                {!! $errors->first('abn', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('occupation')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('Occupation') !!}</div>
        <div class='col-md-6'>
            {!!Form::text('occupation', null, array('class' => 'form-control', 'id'=>'occupation'))!!}
            @if($errors->has('occupation'))
                {!! $errors->first('occupation', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
    <div class="form-group @if($errors->has('commission')) {{'has-error'}} @endif">
        <div class='col-md-2 control-label'>{!!Form::label('Commission') !!}</div>
        <div class='col-md-6'>
            {!!Form::text('commission', null, array('class' => 'form-control', 'id'=>'commission'))!!}
            @if($errors->has('commission'))
                {!! $errors->first('commission', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
            @endif
        </div>
    </div>
</div>