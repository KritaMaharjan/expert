@extends('tenant.layouts.main')

@section('heading')
Email
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i><a href="{{tenant_route('tenant.profile')}}">Email</a></li>
@stop

@section('content')
<link href="{{asset('assets/css/zabuto_calendar.css')}}" rel="stylesheet" type="text/css" />
{{FB::js('assets/plugins/plupload/js/plupload.full.min.js')}}
{{FB::js('assets/js/zabuto_calendar.js')}}
{{FB::js('
  $(document).ready(function () {
      $("#my-calendar").zabuto_calendar({
        language: "en",
        cell_border: true,
        today: true
      });
  });')}}
<?php
$successCallback ="
    var response = JSON.parse(object.response);
    console.log(response);
";
?>
<script type="text/javascript">
$(function(){
    {!! plupload()->button('attachment')->maxSize('800kb')->mimeTypes('image')->url(url('/desk/email/upload/data'))->autoStart(true)->success($successCallback)->init() !!}
});
</script>
           <div class="box box-solid">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="mail-wrap-section clearfix">
                      <div class="col-md-3 bg-white">
                        <div class="box box-solid">
                          
                          <div class="box-body">
                            <div class="row mailbox">
                              <div class="col-md-12 col-sm-12">
                                  <div class="row pad pad-top-0 pad-btm-0">
                                    <div class="col-md-12 pad-5">
                                      <a href="#" class="btn btn-primary btn-flat btn-small">Personal Inbox</a>
                                      <a href="#" class="btn btn-default btn-flat btn-small">Support Inbox</a>
                                    </div>
                                  </div><!-- /.row -->

                                  <div class="table-responsive fix-height">
                                    <!-- THE MESSAGES -->
                                    <table class="table table-mailbox no-mg-btm">
                                      @if($mails)
                                      <tr class="unread">
                                        <td class="small-col"><i class="fa fa-envelope"></i></td>
                                        <td class="name">
                                          <a href="#">John Doe
                                            <small class="subject">Aspergers syn...</small>
                                          </a>
                                        </td>
                                        <td class="time">12:30 PM</td>
                                      </tr>
                                     @endif
                                      
                                    </table>                                    
                                  </div><!-- /.table-responsive -->
                                  <p class="align-right">
                                    <span class="color-grey">1-8 of 500</span>
                                      <a href="#" class="mg-lr-5  color-grey"><i class="fa  fa-chevron-left"></i></a>
                                      <a href="#" class="color-grey"><i class="fa  fa-chevron-right"></i></a>
                                  </p>

                                  <div class="col-md-12 pad-top-only align-right">
                                    <a href="#" data-toggle="modal" data-target="#compose-modal" class="btn btn-primary btn-flat btn-small">New Email</a>
                                    <a href="#" data-toggle="modal" data-target="#compose-modal" class="btn btn-default btn-flat btn-small">New Ticket</a>
                                  </div>
                                </div><!-- /.col (RIGHT) -->
                          </div>
                        </div><!-- /.box -->
                      </div><!-- bg-white -->
                      </div>
                      <div class="col-md-6 bg-white">
                        <div class="box box-solid">
                          <div class="box-header block-header">
                            <h3 class="box-title"><strong>Aspergers syn...</strong>
                            </h3>
                            <p><small class="color-blue">Sent: </small> Mon 3/2/2015 3:52 AM</p>
                            <p><small class="color-blue">To: </small> John@abc.com</p>
                            <div class="link-reply">
                              <button data-toggle="dropdown" class="btn btn-default btn-sm btn-flat dropdown-toggle" type="button">
                                Action <span class="caret"></span>
                              </button>
                              <ul role="menu" class="dropdown-menu">
                                <li><a href="#"><small class="color-grey"><i class="fa fa-reply"></i></small> Reply</a></li>
                                <li><a href="#"><small class="color-grey"><i class="fa fa-mail-forward"></i></small> Forward</a></li>
                                <li><a href="#"><small class="color-grey"><i class="fa fa-close"></i></small> Delete</a></li>
                                
                              </ul>
                            </div>
                            <hr>
                          </div><!-- /.box-header -->
                          <div class="box-body">
                            <p>Hello John,<br>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum egestas pellentesque quam, lobortis ultrices felis. Praesent venenatis vulputate leo. Donec efficitur libero vel lectus finibus sollicitudin. Pellentesque pharetra eleifend viverra. Nulla in volutpat turpis. Ut dolor tellus, aliquam ut tristique id, suscipit quis libero. In tristique id lacus vel ornare. Quisque mauris leo, hendrerit ultrices dolor ac, suscipit tristique nunc.
                            </p>
                            <p>
                              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum egestas pellentesque quam, lobortis ultrices felis. Praesent venenatis vulputate leo. Donec efficitur libero vel lectus finibus sollicitudin. Pellentesque pharetra eleifend viverra. Nulla in volutpat turpis. Ut dolor tellus, aliquam ut tristique id, suscipit quis libero. In tristique id lacus vel ornare. Quisque mauris leo, hendrerit ultrices dolor ac, suscipit tristique nunc.
                            </p>


                          </div>


                        </div><!-- /.box -->
                      </div><!-- bg-white -->
                      <div class="col-md-3">
                        <div class="box-body">
                          <div id="my-calendar"></div>
                        </div>
                      </div>  
                    </div>
                    
                  </div>
                </div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
            @include('tenant.email.compose')

@stop


