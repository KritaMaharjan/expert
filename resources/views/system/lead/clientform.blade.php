<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Client Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('preferred_name')) {{'has-error'}} @endif">
                            {!!Form::label('Preferred Name*') !!}
                            {!!Form::text('preferred_name', null, array('class' => 'form-control', 'id'=>'preferred_name'))!!}
                            @if($errors->has('preferred_name'))
                                {!! $errors->first('preferred_name', '<label class="control-label"
                                                                             for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('phone')) {{'has-error'}} @endif">
                            {!!Form::label('Current Phone Number*') !!}
                            {!!Form::text('phone', null, array('class' => 'form-control', 'id'=>'phone'))!!}
                            @if($errors->has('phone'))
                                {!! $errors->first('phone', '<label class="control-label"
                                                                      for="inputError">:message</label>') !!}
                            @endif
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('given_name')) {{'has-error'}} @endif">
                            {!!Form::label('Given Name') !!}
                            {!!Form::text('given_name', null, array('class' => 'form-control', 'id'=>'given_name'))!!}
                            @if($errors->has('given_name'))
                                {!! $errors->first('given_name', '<label class="control-label"
                                                                         for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('surname')) {{'has-error'}} @endif">
                            {!!Form::label('Surname') !!}
                            {!!Form::text('surname', null, array('class' => 'form-control', 'id'=>'surname'))!!}
                            @if($errors->has('surname'))
                                {!! $errors->first('surname', '<label class="control-label"
                                                                      for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>