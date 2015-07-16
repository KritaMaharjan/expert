<div class="box-body col-lg-6">
    <div class="form-group @if($errors->has('username')) {{'has-error'}} @endif">
        {!!Form::label('Username: ') !!}
            {!!Form::text('username','',array('class' => 'form-control date-box2'))!!}
            @if($errors->has('username'))
                {!! $errors->first('username', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
            @endif
    </div>
    <div class="form-group @if($errors->has('fname')) {{'has-error'}} @endif">
        {!!Form::label('First Name: ') !!}
            {!!Form::text('fname','',array('class' => 'form-control date-box2'))!!}
            @if($errors->has('fname'))
                {!! $errors->first('fname', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
            @endif
    </div>
    <div class="form-group @if($errors->has('lname')) {{'has-error'}} @endif">
        {!!Form::label('Last Name: ') !!}
            {!!Form::text('lname','',array('class' => 'form-control date-box2'))!!}
            @if($errors->has('lname'))
                {!! $errors->first('lname', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
            @endif
    </div>
    <div class="form-group @if($errors->has('phone1')) {{'has-error'}} @endif">
        {!!Form::label('Phone 1:') !!}
            {!!Form::text('phone1','',array('class' => 'form-control date-box2'))!!}
            @if($errors->has('phone1'))
                {!! $errors->first('phone1', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
            @endif
    </div>
    <div class="form-group @if($errors->has('phone2')) {{'has-error'}} @endif">
        {!!Form::label('Phone 2:') !!}
            {!!Form::text('phone2','',array('class' => 'form-control date-box2'))!!}
            @if($errors->has('phone2'))
                {!! $errors->first('phone2', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
            @endif
    </div>
    <div class="form-group @if($errors->has('email')) {{'has-error'}} @endif">
        {!!Form::label('Email Address: ') !!}
            {!!Form::text('email','',array('class' => 'form-control date-box2'))!!}
            @if($errors->has('email'))
                {!! $errors->first('email', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
            @endif
    </div>
    <div class="form-group @if($errors->has('salary')) {{'has-error'}} @endif">
        {!!Form::label('Salary: ') !!}
            {!!Form::text('salary','',array('class' => 'form-control date-box2'))!!}
            @if($errors->has('salary'))
                {!! $errors->first('salary', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
            @endif
    </div>

    <div class="form-group @if($errors->has('occupation')) {{'has-error'}} @endif">
        {!!Form::label('Occupation: ') !!}
        {!!Form::text('occupation','',array('class' => 'form-control date-box2'))!!}
        @if($errors->has('occupation'))
            {!! $errors->first('occupation', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
        @endif
    </div>

    <div class="form-group @if($errors->has('type')) {{'has-error'}} @endif">
        {!!Form::label('Type: ') !!}
            {!!Form::select('type', array(1 => 'PayG', 2 => 'Self-employed'),'',array('class' => 'form-control date-box2'));!!}
            @if($errors->has('type'))
                {!! $errors->first('type', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
            @endif
    </div>

    <div class="form-group @if($errors->has('address')) {{'has-error'}} @endif">
        {!!Form::label('Address: ') !!}
            {!!Form::text('address','',array('class' => 'form-control date-box2'))!!}
            @if($errors->has('address'))
                {!! $errors->first('address', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
            @endif
    </div>

    <div class="form-group @if($errors->has('introducer')) {{'has-error'}} @endif">
        {!!Form::label('Introduced By: ') !!}
            {!!Form::text('introducer','',array('class' => 'form-control date-box2'))!!}
            @if($errors->has('introducer'))
                {!! $errors->first('introducer', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
            @endif
    </div>
</div>
