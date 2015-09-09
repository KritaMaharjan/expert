<div class="box-body col-lg-6">
    <div class="form-group @if($errors->has('preferred_name')) {{'has-error'}} @endif">
        {!!Form::label('Username: ') !!}
            {!!Form::text('preferred_name','',array('class' => 'form-control date-box2'))!!}
            @if($errors->has('preferred_name'))
                {!! $errors->first('preferred_name', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
            @endif
    </div>
    <div class="form-group @if($errors->has('given_name')) {{'has-error'}} @endif">
        {!!Form::label('First Name: ') !!}
            {!!Form::text('given_name','',array('class' => 'form-control date-box2'))!!}
            @if($errors->has('given_name'))
                {!! $errors->first('given_name', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
            @endif
    </div>
    <div class="form-group @if($errors->has('last_name')) {{'has-error'}} @endif">
        {!!Form::label('Last Name: ') !!}
            {!!Form::text('last_name','',array('class' => 'form-control date-box2'))!!}
            @if($errors->has('last_name'))
                {!! $errors->first('last_name', '<label class="control-label error-frm1" for="inputError">:message</label>') !!}
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

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Address Book Entries</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <table class="table table-bordered">
            <tbody>
            <tr>
                <th style="width: 10px">#</th>
                <th>Address</th>
                <th>Current</th>
                <th>Processing</th>
            </tr>
            <tr>
                <td>1.</td>
                <td>Update software</td>
                <td><span class="label label-success">Yes</span></td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-info" type="button">Action</button>
                        <button data-toggle="dropdown" class="btn btn-info dropdown-toggle"
                                type="button">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Edit</a></li>
                            <li><a href="#">Add as current</a></li>
                            <li><a href="#">Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Clean database</td>
                <td><span class="label label-danger">No</span></td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-info" type="button">Action</button>
                        <button data-toggle="dropdown" class="btn btn-info dropdown-toggle"
                                type="button">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="#">Edit</a></li>
                            <li><a href="#">Add as current</a></li>
                            <li><a href="#">Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>