{!! Form::open(array('method'=>'POST', 'name'=>'sickform','files'=>true, 'class'=>'form-horizontal sickform')) !!}
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="group" value="sick">         
    <div class="form-group no-mg">
      <label class="control-label" name="vacation_days" value="{{ $vacation['vacation_days'] }}">Vacation Days</label>
      <div class="@if($errors->has('vacation_days')) {{'has-error'}} @endif">
        {!!Form::text('vacation_days',$vacation['vacation_days'],array('class' => 'form-control','id' => 'vacation_days'))!!}  
        @if($errors->has('vacation_days'))
          {!! $errors->first('vacation_days', '<label class="control-label" for="inputError">:message</label>') !!}
        @endif
      </div>
    </div>
    <div class="form-group no-mg">
      <label class="control-label" name="sick_days" value="{{ $vacation['sick_days'] }}">Sick Days</label>
      <div class="@if($errors->has('sick_days')) {{'has-error'}} @endif">
        {!!Form::text('sick_days',$vacation['sick_days'],array('class' => 'form-control','id' => 'sick_days'))!!}  
        @if($errors->has('sick_days'))
          {!! $errors->first('sick_days', '<label class="control-label" for="inputError">:message</label>') !!}
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
        var datatosave = $('.vacationform').serialize();
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

