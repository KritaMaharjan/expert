
{!! Form::open(array('method'=>'POST', 'name'=>'vacationform','files'=>true, 'class'=>'form-horizontal vacationform')) !!}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="group" value="vacation">	        
    <div class="form-group no-mg">
      <label class="control-label" name="vacation_days" value="{{ $vacation['vacation_days'] }}">Vacation Days</label>
      <div class="@if($errors->has('vacation_days')) {{'has-error'}} @endif">
      	{!!Form::text('vacation_days',$vacation['vacation_days'],array('class' => 'form-control','id' => 'vacation_days'))!!}  
      	@if($errors->has('vacation_days'))
       		{!! $errors->first('vacation_days', '<label class="control-label has-error" for="inputError" style="color: red !important;">:message</label>') !!}
      	@endif
      </div>
    </div>
    <div class="form-group no-mg">
      <label class="control-label" name="sick_days" value="{{ $vacation['sick_days'] }}">Sick Days</label>
      <div class="@if($errors->has('sick_days')) {{'has-error'}} @endif">
      	{!!Form::text('sick_days',$vacation['sick_days'],array('class' => 'form-control','id' => 'sick_days'))!!}  
      	@if($errors->has('sick_days'))
       		{!! $errors->first('sick_days', '<label class="control-label has-error" for="inputError" style="color: red !important;">:message</label>') !!}
      	@endif
      </div>
    </div>
   
    
    
    <div class="form-group no-mg">        
      <div class="col-sm-offset-2 col-sm-10">
      	 {!! Form::button('Save', array('class'=>'btn btn-primary pull-right savevacation','link'=>route('tenant.setup.fixUpdate'))) !!}
        <!-- <button type="submit" class="btn btn-primary pull-right">Log In &nbsp;<i class="fa  fa-sign-in"></i></button> -->
      </div>
    </div>
	<div id="success"> </div>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function () {
 
    $( '.savevacation' ).on( 'click', function() {
        $this = $(this);
        $('.alert-info').remove();
        var datatosave = $('.vacationform').serialize();
        var url = appUrl+'setting/system/fixupdate';/*$this.attr('link');
*/    $this.attr('disabled', 'disabled');
        
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
                           $('.savevacation').removeAttr('disabled');
                        $(this).val('Save');
                      } else if(data.status == 'false') {
                       
                        $.each(data.errors,function(i,v){
                             $('#'+i).after('<label class="control-label error" for="inputError">'+v+'</label>');
                        });
                         $(this).val('Save');
                          $('.savevacation').removeAttr('disabled');
                      }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                alert('No response from server');
                 $(this).val('Save');
                  $('.savevacation').removeAttr('disabled');

            });
            return false;

  });
});
</script>

