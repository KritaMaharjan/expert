<div class="box-body">
    <div class="form-group">
        {!! Form::label('subject', 'Subject') !!}
        {!! Form::text('subject',null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('due_date', 'Due Date') !!}
        {!! Form::text('due_date',null,['class'=>'form-control  date-picker']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', 'Body') !!}
        {!! Form::textarea('body',null,['class'=>'form-control']) !!}
    </div>

</div>
