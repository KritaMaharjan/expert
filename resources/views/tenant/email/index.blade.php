@extends('tenant.layouts.main')

@section('heading')
Email
{{tenant()->folder('customer')->copyFromTemp('1.txt', '2.txt')}}
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> <a href="{{tenant_route('tenant.profile')}}">Email</a></li>
@stop

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" type="text/css" /> 

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}" type="text/javascript"></script>
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
    {!! plupload()->button('attachment')->maxSize('20mb')->mimeTypes('image')->url(url('/desk/email/upload/data'))->autoStart(true)->success($successCallback)->init() !!}
});
</script>
           <div class="box box-solid">
              <div class="box-body">
                <div class="">
                  <div class="col-md-12 pad-5">
                    <div id="tab-header" class="col-md-12 pad-5 mg-l-1 border-btm">
                        <a href="javascript:;" id="personal" class="type inbox-active btn btn-flat" folder=1>Personal</a>
                        <a href="javascript:;" id="support" class="type btn btn-flat" folder=1>Support</a>
                      </div>
                    </div><!-- /.row -->
                    <div class="mail-wrap-section clearfix">
                      <div class="col-md-2 width-sm">
                      <div class="box-header">
                        
                      </div>
                        <a href="#" title="New Email" data-original-title="New Email" class="btn btn-block-small btn-primary btn-small" data-toggle="modal" data-type="personal"  data-target="#compose-modal"><i class="fa fa-pencil"></i> New Email</a>
                        <a href="#" title="New Ticket" data-original-title="New Ticket" class="btn btn-block-small btn-default btn-small" data-toggle="modal" data-type="support" data-target="#compose-modal"><i class="fa fa-pencil"></i> New Ticket</a>
                        <div class="box box-solid">                          
                          <div>
                              <ul class="nav nav-pills nav-stacked">
                                <li class="header">Folders</li>
                                {{--<li class="active">
                                    <a href="javascript:;" id="inbox" class="folder"><i class="fa fa-inbox"></i> Inbox</a>
                                </li>
                                <li>
                                    <a href="javascript:;" id="sent" class="folder"><i class="fa fa-mail-forward"></i> Sent</a>
                                </li>--}}
                                <li class="active">
                                    <a href="javascript:;" id="inbox" class="folder"><i class="fa fa-inbox"></i> Inbox</a>
                                </li>
                                <li>
                                    <a href="javascript:;" id="sent" class="folder"><i class="fa fa-mail-forward"></i> Sent</a>
                                </li>
                              </ul>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4 bg-white">
                        <div class="box box-solid">
                          <div class="box-body">

                          <div class="row mailbox" >
                            <div class="col-md-12 col-sm-12">
                              <div id="email-list"></div>
                            </div><!-- /.col (RIGHT) -->
                          </div>
                        </div><!-- /.box -->
                      </div><!-- bg-white -->
                      </div>
                      <div id="email-single" class="col-md-6 bg-white">

                      </div><!-- bg-white -->

                    </div>
                    
                  </div>
                </div>
              </div><!-- /.box-body -->
            </div><!-- /.box -->
            @include('tenant.email.compose')
@stop