{!! Form::open(array('method'=>'POST', 'name'=>'fixitform','files'=>true, 'class'=>'form-horizontal fixitform')) !!}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="group" value="fix">	        
    <div class="form-group no-mg">
      <label class="control-label" name="swift_num" value="{{ $fix['swift_num'] }}">Swift Number</label>
      <div class="@if($errors->has('swift_num')) {{'has-error'}} @endif">
      	{!!Form::text('swift_num',$fix['swift_num'],array('class' => 'form-control','id' => 'swift_num'))!!}  
      	@if($errors->has('swift_num'))
       		{!! $errors->first('swift_num', '<label class="control-label" for="inputError">:message</label>') !!}
      	@endif
      </div>
    </div>
    <div class="form-group no-mg">
      <label class="control-label" name="iban_num" value="{{ $fix['iban_num'] }}">IBAN Number</label>
      <div class="@if($errors->has('iban_num')) {{'has-error'}} @endif">
      	{!!Form::text('iban_num',$fix['iban_num'],array('class' => 'form-control','id' => 'iban_num'))!!}  
      	@if($errors->has('iban_num'))
       		{!! $errors->first('iban_num', '<label class="control-label" for="inputError">:message</label>') !!}
      	@endif
      </div>
    </div>
    <div class="form-group no-mg">
      <label class="control-label" name="telephone" value="{{ $fix['telephone'] }}">Telephone</label>
      <div class="@if($errors->has('telephone')) {{'has-error'}} @endif">
      	{!!Form::text('telephone',$fix['telephone'],array('class' => 'form-control','id' => 'telephone'))!!}  
      	@if($errors->has('telephone'))
       		{!! $errors->first('telephone', '<label class="control-label" for="inputError">:message</label>') !!}
      	@endif
      </div>
    </div>
    <div class="form-group no-mg">
      <label class="control-label" name="fax" value="{{ $fix['fax'] }}">Fax</label>
      <div class="@if($errors->has('fax')) {{'has-error'}} @endif">
      	{!!Form::text('fax',$fix['fax'],array('class' => 'form-control','id' => 'fax'))!!}  
      	@if($errors->has('fax'))
       		{!! $errors->first('fax', '<label class="control-label" for="inputError">:message</label>') !!}
      	@endif
      </div>
    </div>
    <div class="form-group no-mg">
      <label class="control-label" name="website" value="{{ $fix['website'] }}">Website</label>
      <div class="@if($errors->has('website')) {{'has-error'}} @endif">
      	{!!Form::text('website',$fix['website'],array('class' => 'form-control','id' => 'website'))!!}  
      	@if($errors->has('website'))
       		{!! $errors->first('website', '<label class="control-label" for="inputError">:message</label>') !!}
      	@endif
      </div>
    </div>
    <div class="form-group no-mg">
      <label class="control-label" name="service_email" value="{{ $fix['service_email'] }}">Business Customer Service Email</label>
      <div class="@if($errors->has('service_email')) {{'has-error'}} @endif">
      	{!!Form::email('service_email',$fix['service_email'],array('class' => 'form-control','id' => 'service_email'))!!}  
      	@if($errors->has('service_email'))
       		{!! $errors->first('service_email', '<label class="control-label" for="inputError">:message</label>') !!}
      	@endif
      </div>
    </div>

    <div class="form-group no-mg">
      <label class="control-label">Upload Logo</label>
      <div id="container">
            <div id="uploader">
                <a id="attachment" href="javascript:;" class="btn btn-success btn-file">
                    Select File
                </a>
            </div>
      </div>

      <div id='filelist'>
          Your browser doesn't have Flash, Silverlight or HTML5 support.
      </div>
    </div>
    
    
    <div class="form-group no-mg">        
      <div class="col-sm-offset-2 col-sm-10">
      	 {!! Form::button('Save', array('class'=>'btn btn-primary pull-right savefix','link'=>route('tenant.setup.fixUpdate'))) !!}
        <!-- <button type="submit" class="btn btn-primary pull-right">Log In &nbsp;<i class="fa  fa-sign-in"></i></button> -->
      </div>
    </div>
	<div id="success"> </div>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function () {
 
    $( '.savefix' ).on( 'click', function() {
        $this = $(this);
        var datatosave = $('.fixitform').serialize();
        var url = appUrl+'setting/system/fixupdate';/*$this.attr('link');
*/
        $.ajax({
            url: url,
            dataType: 'json',
            data: datatosave,
            type: 'post',
            beforeSend: function()
            {
              
              $(".error").remove();
              $(".alert-info").remove();
              $(this).val('Loading');
            }
           })
            .done(function(data)
            {
                     if(data.status == 'true')
                      {
                         
                         $('.box-solid').before('<p class="alert alert-info">Setting Updated successfully</p>');
                        $(this).val('Save');
                      } else if(data.status == 'false') {
                       
                        $.each(data.errors,function(i,v){
                             $('#'+i).after('<label class="control-label error" for="inputError">'+v+'</label>');
                        });
                         $(this).val('Save');
                      }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                alert('No response from server');
                 $(this).val('Save');
            });
            return false;

  });
});
</script>

{{FB::js('assets/plugins/plupload/js/plupload.full.min.js')}}
<?php
$successCallback ="
  var response = JSON.parse(object.response);
  var wrap = $('#'+file.id);
  wrap.append('<input type=\"hidden\" class=\"attachment\" name=\"logo\" value=\"'+response.data.fileName+'\" />');
  wrap.append('<a href=\"#\" data-action=\"compose\" data-url=\"'+response.data.fileName+'\" class=\"cancel_upload\" ><i class=\"fa fa-times\"></i></a>');
  $('#container').hide();
  $('.logo').remove();
  $('#container').before('<img class=\"logo\" src='+response.data.pathName+'/>');
";
FB::js(plupload()->button('uploader')->maxSize('2mb')->mimeTypes('image')->resize(200, 135)->url(url('file/upload/data?folder=system'))->autoStart(true)->success($successCallback)->init());

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
                              $('.logo').remove();
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
                  $('.logo').remove();
                  $('#container').show();
              }
          });";
FB::js($js);

?>

