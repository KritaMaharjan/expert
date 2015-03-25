{!! Form::open(array('method'=>'POST', 'name'=>'global','files'=>true, 'class'=>'form-horizontal globalform')) !!}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">    
    

      <div class="form-group no-mg">
      <label class="control-label" name="currency" value="">Currency</label>
      <div class="@if($errors->has('currency')) {{'has-error'}} @endif">
        {!! Form::select('currency', array(
                                        'NOK' => 'NOK',
                                        'GBP' => 'GBP',
                                        'EUR' => 'EUR',
                                        'USD' => 'USD',
                                        'AUD' => 'AUD',
                                        'NZD' => 'NZD',
                                        'CHF' => 'CHF',
                                        'PLN' => 'PLN',
                                        'DKK' => 'DKK',
                                        'SEK' => 'SEK',
                                        'CNY' => 'CNY'
                            ), null, array('class' => 'form-control')) !!}
        @if($errors->has('currency'))
          {!! $errors->first('currency', '<label class="control-label" for="inputError">:message</label>') !!}
        @endif
      </div>
    </div>

     <div class="form-group no-mg">
      <label class="control-label" name="dateformat" value="">Date Format</label>
      <div class="@if($errors->has('dateformat')) {{'has-error'}} @endif">
        {!! Form::select('dateformat', array(
                                        'mm/dd/yy' => 'mm/dd/yy',
                                        'yy-mm-dd' => 'yy-mm-dd',
                                        'd M, y' => 'd M, y',
                                        'd MM, y' => 'd MM, y',
                                         'DD, d MM, yy' => 'DD, d MM, yy',
                                        
                                      
                            ), null, array('class' => 'form-control')) !!}
        @if($errors->has('dateformat'))
          {!! $errors->first('dateformat', '<label class="control-label" for="inputError">:message</label>') !!}
        @endif
      </div>
    </div>

  
         

    <div class="form-group no-mg">
      <label class="control-label" name="vat" value="">Vat</label>
      <div class="@if($errors->has('vat')) {{'has-error'}} @endif">
      	{!!Form::text('vat','',array('class' => 'form-control','id' => 'dateformat'))!!}  
      	@if($errors->has('vat'))
       		{!! $errors->first('vat', '<label class="control-label" for="inputError">:message</label>') !!}
      	@endif
      </div>
    </div>


   
  
    
    <div class="form-group no-mg">        
      <div class="col-sm-offset-2 col-sm-10">
      	 {!! Form::button('Save', array('class'=>'btn btn-primary pull-right globe','link'=>route('tenant.setup.fixUpdate'))) !!}
        <!-- <button type="submit" class="btn btn-primary pull-right">Log In &nbsp;<i class="fa  fa-sign-in"></i></button> -->
      </div>
    </div>
	<div id="success"> </div>
{!! Form::close() !!}
<script type="text/javascript">
$(document).ready(function () {
 
    $( '.globe' ).on( 'click', function() {
        $this = $(this);
        var datatosave = $('.globalform').serialize();
        var url = appUrl+'setting/system/fixupdate';
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

