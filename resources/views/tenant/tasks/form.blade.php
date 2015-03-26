<div class="box-body">
    <div class="form-group">
        {!! Form::label('subject', 'Subject') !!}
        {!! Form::text('subject',null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('due_date', 'Due Date') !!}
        <div class='input-group'>
              {!! Form:: text('due_date', null, array('class' => 'form-control date-time-picker')) !!}
              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>
        {{--{!! Form::text('due_date',null,['class'=>'form-control  date-time-picker']) !!}--}}
    </div>

    <div class="form-group">
        {!! Form::label('body', 'Body') !!}
        {!! Form::textarea('body',null,['class'=>'form-control']) !!}
    </div>

</div>
