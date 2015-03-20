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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<style>
.ui-autocomplete-loading {
background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
}
.ui-autocomplete {z-index: 99999999}
</style>
{{FB::js('assets/plugins/plupload/js/plupload.full.min.js')}}
{{FB::js('assets/js/desk/email.js')}}
{{--
{{FB::js('assets/js/zabuto_calendar.js')}}
{{FB::js('
  $(document).ready(function () {
      $("#my-calendar").zabuto_calendar({
        language: "en",
        cell_border: true,
        today: true
      });
  });')}}
--}}
<?php
$successCallback ="
    var response = JSON.parse(object.response);
      var wrap = $('#attachment');
      wrap.after('<input type=\"hidden\" class=\"attachment\" name=\"attach[]\" value=\"'+response.data.fileName+'\" />');
";
?>
<script type="text/javascript">
$(function(){
    {!! plupload()->button('attachment')->maxSize('2mb')->mimeTypes('image')->url(url('/desk/email/upload/data'))->autoStart(true)->success($successCallback)->init() !!}
});
</script>
           <div class="box box-solid">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="mail-wrap-section clearfix">
                      <div class="col-md-4 bg-white">
                        <div class="box box-solid">
                          
                          <div class="box-body">
                            <div class="row mailbox">
                              <div class="col-md-12 col-sm-12">
                                  <div class="row pad pad-top-0 pad-btm-0">
                                    <div class="col-md-12 pad-6">
                                      <a href="#" class="btn btn-primary btn-flat btn-small">Personal Inbox</a>
                                      <a href="#" class="btn btn-default btn-flat btn-small">Support Inbox</a>
                                    </div>
                                  </div><!-- /.row -->

                                  <div class="table-responsive fix-height">
                                    <!-- THE MESSAGES -->
                                    <table class="table table-mailbox no-mg-btm">
                                        <tbody>
                                              @if(!empty($mails))
                                              @foreach($mails as $mail)

                                              <tr class="unread">
                                                <td class="small-col"><i class="fa fa-envelope"></i></td>
                                                <td class="name">
                                                  <a href="#">{{$mail->to or ''}}
                                                    <small class="subject">{{$mail->subject}}</small>
                                                  </a>
                                                </td>
                                                <td class="time">{{$mail->created_at->diffForHumans()}}</td>
                                              </tr>
                                              @endforeach
                                             @endif
                                        </tbody>
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
                      <div class="col-md-8 bg-white">
                        <div class="box box-solid">
                          <div class="box-header block-header">

                          <?php foreach($mails as $mail):?>

                            <h3 class="box-title"><strong><?php echo $mail->subject;?></strong>
                            </h3>
                            <p><small class="color-blue">Sent: </small> <?php echo $mail->created_at->format('D m/d/Y h:i A');?></p>
                             <?php $receiver = $mail->receivers;?>
                             <p><small class="color-blue"> To: </small>
                                @foreach($receiver as $to)
                                    @if($to->type ==1)
                                       {{ '('.$to->customer_id.') '. $to->email}};
                                    @endif
                                 @endforeach
                             </p>

                               <p><small class="color-blue"> CC: </small>
                                 @foreach($receiver as $cc)
                                     @if($cc->type ==2)
                                        {{ '('.$cc->customer_id.') '. $cc->email  }};
                                     @endif
                                  @endforeach
                              </p>


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
                            <i class="fa fa-attach"></i> :
                           <?php $attachments = $mail->attachments;?>
                            @foreach($attachments as $file)
                                <a href="{{$file->path()}}">{{$file->file}}</a>
                            @endforeach
                            <hr>
                          </div><!-- /.box-header -->


                          <div class="box-body">
                                <?php echo nl2br($mail->message);?>


                              <hr/>
                               <p>Note :</p>
                               <?php echo nl2br($mail->note);?>

                          </div>



                        <?php
                         break;
                        endforeach;?>

                        </div><!-- /.box -->
                      </div><!-- bg-white -->

                    </div>
                    
                  </div>
                </div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
            @include('tenant.email.compose')
@stop


