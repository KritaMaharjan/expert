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

    {{--<div class="form-group" id="file">
        {!! Form::label('file', 'File') !!}
        {!! Form::file('file') !!}
    </div>--}}

    <div id="container">
          <div id="uploader">
              <button class="btn btn-primary">Upload</button>
          </div>
    </div>
    <div id='filelist'>
        Your browser doesn't have Flash, Silverlight or HTML5 support.
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

{{FB::js('assets/plugins/plupload/js/plupload.full.min.js')}}
<?php
$successCallback ="
  var response = JSON.parse(object.response);
  var wrap = $('#'+file.id);
  wrap.append('<input type=\"hidden\" class=\"attachment\" name=\"file[]\" value=\"'+response.data.fileName+'\" />');
  wrap.append('<a href=\"#\" data-action=\"compose\" data-url=\"'+response.data.fileName+'\" class=\"cancel_upload\" ><i class=\"fa fa-times\"></i></a>');
  $('#container').hide();
";
FB::js(plupload()->button('uploader')->maxSize('20mb')->mimeTypes('file')->url(url('file/upload/data?folder=todo'))->autoStart(true)->success($successCallback)->init());

$js ="$(document).on('click', '.cancel_upload', function (e) {
              e.preventDefault();
              var url = $(this).data('url');
              var wrap = $(this).parent();
              var action = $(this).data('action');

              if (!confirm('Are you sure, you want to delete file?')) return false;

              if (action == 'compose') {
                  $.ajax({
                      url: appUrl + 'file/delete',
                      type: 'GET',
                      dataType: 'json',
                      data: {file: url, folder:'expense'}
                  })
                      .done(function (response) {
                          if (response.status == 1) {
                              wrap.remove();
                              $('.bill_image').remove();
                              $('#container').show();
                          }
                          else {
                              alert(response.data.error);
                          }
                      })
                      .fail(function () {
                          alert('Connect error!');
                      })
              }
              else {
                  $('#edit-filelist').remove();
                  wrap.remove();
                  $('.bill_image').remove();
                  $('.edit-attachment').remove();
                  $('#container').show();
              }
          });";
FB::js($js);



