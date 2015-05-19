<div class="box-body">
    <div class="form-group">
        {!! Form::label('subject', 'Subject') !!}
        {!! Form::text('subject',null,['class'=>'form-control']) !!}
    </div>

 
    <div class="form-group">
        {!! Form::label('', 'Due Date') !!}
        <div id="due_date" class="input-group date">
            {!! Form::text('due_date',null,['class'=>'form-control due_date']) !!}
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
    </div>

    <div class="bootstrap-timepicker">
        <div class="form-group" >
             {!! Form::label('', 'Due Time') !!}
              <div class="input-group" id="due_time">
                 {!! Form::text('due_time',null,['class'=>'form-control timepicker']) !!}
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
              </div>
        </div>
    </div>

    <div class="form-group">
        <div id="container">
            <a id="attachment" href="javascript:;" class="btn btn-success btn-file">
                Upload
            </a>
        </div>
        <p class="help-block">Max. 20MB</p>
         <div id='filelist'>Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
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

<?php
$successCallback ="
  var response = JSON.parse(object.response);
  var wrap = $('#'+file.id);
  wrap.append('<input type=\"hidden\" class=\"attachment\" name=\"file[]\" value=\"'+response.data.fileName+'\" />');
  wrap.append('<a href=\"#\" data-action=\"compose\" data-url=\"'+response.data.fileName+'\" class=\"cancel_upload\" ><i class=\"fa fa-times\"></i></a>');
";
FB::js(plupload()->button('attachment')->maxSize('20mb')->mimeTypes('file')->url(url('file/upload/data?folder=todo'))->autoStart(true)->success($successCallback)->init());

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
                  $('.edit-attachment').remove();
                  $('#container').show();
              }
          });";
FB::js($js);



