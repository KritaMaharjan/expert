<div class="box-body">
    <div class="form-group">
        {!! Form::label('subject', 'Subject') !!}
        {!! Form::text('subject',null,['class'=>'form-control']) !!}
    </div>

 
    <div class="form-group">
        {!! Form::label('', 'Due Date') !!}
        <div id="due_date" class="input-group date">
            {!! Form::text('due_date',$due_date,['class'=>'form-control due_date']) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>

    <div class="bootstrap-timepicker">
        <div class="form-group" >
             {!! Form::label('', 'Due Time') !!}
              <div class="input-group" id="due_time">
                 {!! Form::text('due_time',$due_time,['class'=>'form-control timepicker']) !!}
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
              </div>
        </div>
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



