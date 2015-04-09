<div class="box-body">
    <div class="form-group">
        {!! Form::label('subject', 'Subject') !!}
        {!! Form::text('subject',null,['class'=>'form-control']) !!}
    </div>

 
    <div class="form-group">
        {!! Form::label('due_date', 'Due Date') !!}
          <div id="datetimepicker1" class="input-group date">
              {!! Form::text('due_date',null,['class'=>'form-control due_date','id'=>'due_date']) !!}
              {{--<input name="due_date" type="text" class="form-control" />--}}
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

<script type="text/javascript">
  $(function(){
   
    
    $('.due_date').datepicker({format: 'yyyy-mm-dd',startDate :new Date()});
  });
</script>




