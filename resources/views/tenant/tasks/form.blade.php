<div class="box-body">
    <div class="form-group">
        {!! Form::label('subject', 'Subject') !!}
        {!! Form::text('subject',null,['class'=>'form-control']) !!}
    </div>

 
    <div class="form-group" id="due_date">
        {!! Form::label('due_date', 'Due Date') !!}
            <div id="datetimepicker1" class="input-group date">
                {!! Form::text('due_date',null,['class'=>'form-control due_date']) !!}
                {{--<input name="due_date" type="text" class="form-control" />--}}
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        {{--{!! Form::text('due_date',null,['class'=>'form-control  date-time-picker']) !!}--}}
    </div>

    <div class="bootstrap-timepicker">
        <div class="form-group" id="due_time">
             {!! Form::label('due_time', 'Due Time') !!}
              <div class="input-group">
                 {!! Form::text('due_time',null,['class'=>'form-control timepicker']) !!}
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
              </div>
        </div>
    </div>

    <div class="form-group" id="file">
        {!! Form::label('file', 'File') !!}
        {!! Form::file('file') !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', 'Description') !!}
        {!! Form::textarea('body',null,['class'=>'form-control']) !!}
    </div>

</div>

<link href="http://demo.mashbooks.app/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>

<script type="text/javascript">
  $(function(){
    $('.due_date').datepicker({format: 'yyyy-mm-dd',startDate :new Date()});
    $('.timepicker').timepicker({ showInputs: false});
  });
</script>



