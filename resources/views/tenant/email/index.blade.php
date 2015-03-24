@extends('tenant.layouts.main')

@section('heading')
Email
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> <a href="{{tenant_route('tenant.profile')}}">Email</a></li>
@stop

@section('content')
<link href="{{asset('assets/css/zabuto_calendar.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<style>
.ui-autocomplete-loading {
background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
}

#filelist>div {position: relative}
#filelist a.cancel_upload {  float: right;
                             top: 0px;
                             position: absolute;
                             right: 1px;}

.ui-autocomplete {z-index: 99999999}
</style>
{{FB::js('assets/plugins/plupload/js/plupload.full.min.js')}}
{{FB::registerModal()}}
{{FB::js('assets/js/desk/email.js')}}
<?php
$successCallback ="
  var response = JSON.parse(object.response);
  var wrap = $('#'+file.id);
  wrap.append('<input type=\"hidden\" class=\"attachment\" name=\"attach[]\" value=\"'+response.data.fileName+'\" />');
  wrap.append('<a href=\"#\" data-action=\"compose\" data-url=\"'+response.data.fileName+'\" class=\"cancel_upload\" ><i class=\"fa fa-times\"></i></a>');
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

                          <div class="row mailbox" >
                            <div class="col-md-12 col-sm-12">
                                <div class="row pad pad-top-0 pad-btm-0">
                                  <div class="col-md-12 pad-6">
                                    <a href="javascript:;" id="personal" class="inbox btn btn-default  btn-flat btn-small btn-primary">Personal Inbox</a>
                                    <a href="javascript:;" id="support" class="inbox btn btn-default btn-flat btn-small">Support Inbox</a>
                                  </div>
                                </div><!-- /.row -->

                                <div id="email-list" style="height: 485px;"></div>

                               <div class="col-md-12 pad-top-only align-right">
                                   <a href="#" title="New Email" data-original-title="New Email" class="btn btn-primary btn-flat btn-small"  data-toggle="modal" data-type="personal"  data-target="#compose-modal">New Email</a>
                                   <a href="#" title="New Ticket" data-original-title="New Ticket" class="btn btn-default btn-flat btn-small"  data-toggle="modal" data-type="support" data-target="#compose-modal">New Ticket</a>
                                  </div>
                                </div><!-- /.col (RIGHT) -->
                            </div>




                          </div><!-- /.box -->
                      </div><!-- bg-white -->
                      </div>
                      <div id="email-single" class="col-md-8 bg-white">

                      </div><!-- bg-white -->

                    </div>
                    
                  </div>
                </div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
            @include('tenant.email.compose')
@stop


