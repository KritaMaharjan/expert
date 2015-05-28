<div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">Register Court Date to Todo List</h3>
        </div>
        <div class="box-body">
            {!! Form::open(array('method'=>'POST', 'url'=>tenant()->url('tasks'), 'id'=>'court-date-form')) !!}
            <div class="form-group">
                {!! Form::label('subject', 'Subject') !!}
                {!! Form::text('subject',null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('due_date', 'Court Date') !!}
                  <div id="datetimepicker1" class="input-group date">
                      {!! Form::text('due_date',null,['class'=>'form-control due_date','id'=>'due_date']) !!}
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
            </div>
           <div class="bootstrap-timepicker">
            <div class="form-group">
                 {!! Form::label('time', 'Time') !!}
                  <div class="input-group">
                     {!! Form::text('due_time',null,['class'=>'form-control timepicker','id'=>'due_time']) !!}
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
            </div>
            </div>


            <div class="form-group">
                {!! Form::label('body', 'Description') !!}
                {!! Form::textarea('body',$body,['class'=>'form-control']) !!}
            </div>

             <div id="container">
                  <div id="uploader">
                      <button class="btn btn-primary">Upload</button>
                  </div>
            </div>
            <div id='filelist'>
                Your browser doesn't have Flash, Silverlight or HTML5 support.
            </div>



            <div class="box-footer clearfix">
                <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
                <input type="submit" class="btn btn-primary task-submit" value="Add" />
            </div>
            {!! Form::close() !!}
        </div>

        <script type="text/javascript">
          $(function(){
            $('.due_date').datepicker({format: 'yyyy-mm-dd',startDate :new Date()});
            $(".timepicker").timepicker({ showInputs: false});

            function notify(type, text) {
                return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
            }

            $(document).on('submit', '#court-date-form', function (e) {
                    e.preventDefault();
                    var form = $(this);
                    var formAction = form.attr('action');
                    var formData = form.serialize();

                    form.find('.task-submit').val('loading...');
                    form.find('.task-submit').attr('disabled', 'disabled');

                    form.find('.has-error').removeClass('has-error');
                    form.find('label.error').remove();
                    form.find('.callout').remove();

                    $.ajax({
                        url: formAction,
                        type: 'POST',
                        dataType: 'json',
                        data: formData
                    })
                        .done(function (response) {
                            if (response.status === 1) {
                                $('#fb-modal').modal('hide');
                                    $('#app-content .content').prepend(notify('success', 'Court date added to Todo.'));
                                setTimeout(function () {
                                    $('.callout').remove()
                                }, 5000);
                            }
                            else {

                                if ("errors" in response.data) {

                                    $.each(response.data.errors, function (id, error) {
                                        $('.modal-body #' + id).parent().addClass('has-error')
                                        $('.modal-body #' + id).after('<label class="error error-' + id + '">' + error[0] + '<label>');
                                    })
                                }

                                if ("error" in response.data) {
                                    form.prepend(notify('danger', response.data.error));
                                }

                            }
                        })
                        .fail(function () {
                            alert('something went wrong');
                        })
                        .always(function () {
                            form.find('.task-submit').removeAttr('disabled');
                            form.find('.task-submit').val('Add');
                        });
                });
            });

        </script>
</div>



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

?>
