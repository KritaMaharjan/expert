@extends('tenant.layouts.main')

@section('heading')
SMTP Settings
@stop

@section('breadcrumb')
    @parent
    <li>Setting</li>
    @if(current_user()->isAdmin)<li>Email</li>@endif
@stop

@section('content')
<div class="box box-solid">
	<div class="row">
        <div class="col-md-6">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom no-shadow">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#personal-smtp" data-toggle="tab">Personal</a></li>
              <li><a href="#support-smtp" data-toggle="tab">Support</a></li>
            
              
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="personal-smtp">
              	@include('tenant.setting.personalsmtp')

              </div><!-- /.tab-pane -->
              @if(current_user()->isAdmin)
              <div class="tab-pane" id="support-smtp">
              	@include('tenant.setting.supportsmtp')

              </div><!-- /.tab-pane -->
              @endif

            </div><!-- /.tab-content -->
          </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->
    </div>

</div>

<script type="text/javascript">
$(document).ready(function () {
 
  $( '.save' ).on( 'click', function() {
        $this = $(this);
        var datatosave = $(this).closest('form').serialize();
         var url = $this.attr('link');

        $.ajax({
            url: url,
            dataType: 'json',
            data: datatosave,
            type: 'post',
            beforeSend: function()
            {
              $this.val('Loading');

              $( '.save' ).attr('disabled','disabled');
              $this.closest('form').find(".error").remove();
              $(".alert-info").remove();
            }
           })
            .done(function(data)
            {
                     if(data.status == 'true')
                      {
                         var title = $this.closest('form').prev('h4').text();
                         console.log(title);
                          $('.box-solid').before('<p class="alert alert-info">'+title+' setting updated successfully</p>');
                          $this.val('Save');
                          $( '.save' ).attr('disabled',false);
                      } else if(data.status == 'false') {
                     
                        $.each(data.errors,function(i,v){


                             $this.closest('form').find('input[name='+i+']').after('<label class="control-label error" for="inputError">'+v+'</label>');
                        });
                         $this.val('Save');
                         $( '.save' ).attr('disabled',false);
                      }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                alert('No response from server');
                $this.val('Save');
                $( '.save' ).attr('disabled',false);
            });
            return false;


    });
});
</script>

@stop


