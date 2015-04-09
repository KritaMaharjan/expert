{{--Load JS--}}
{{FB::registerModal()}}
{{FB::js('assets/js/customer.js')}}
{{FB::js('assets/js/desk/email.js')}}

@extends('tenant.layouts.main')

@section('heading')
Customers
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> Customers</li>
    <li><i class="fa fa-cog"></i> Customer Card</li>
@stop


@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" type="text/css" /> 

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}" type="text/javascript"></script>
{{FB::js('assets/plugins/plupload/js/plupload.full.min.js')}}


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


        <div class="row">  
            <div class="col-md-4">
              <!-- general form elements -->
              <div class="box box-solid">
                <div class="box-header">
                  <h3 class="box-title">Customer Card</h3>
                  <div class="icon-block">
                    <a href="javascript:;" title="Edit" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="{{tenant()->url('customer/'.$customer['id'].'/edit')}}" data-target="#fb-modal"><i class="fa fa-edit"></i></a>
                   
                    <a href="javascript:;" class="btn-delete-customer_each" title="Delete"><i class="fa fa-trash-o"></i></a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="customer-info">
                    <p><strong>{{$customer['name']}}</strong></p>
                    <p><strong>{{$customer->dob}}</strong></p>
                    <p class="customer-address">
                      <strong>{{$customer->street_name}}  {{$customer->street_number}}</strong><br />
                      <strong>{{$customer->postcode}} {{$customer->town}}</strong><br />
                      <strong></strong>
                    </p>
                    <p><strong>{{$customer->telephone}}</strong> <small>(Telephone)</small><br />
                       <strong>{{$customer->mobile}}</strong> <small>(Mobile)</small>
                    </p>
                   <a href="#" data-toggle="modal" data-target="#compose-modal">{{$customer->email}}</a>

                    <div class="form-group radio-box">
                      <label>
                        <input type="radio" name="r1" value="1" class="minimal minimal_status" <?php if($customer->status == 1) echo 'checked=checked '; ?> /> Active
                      </label>
                      <label>
                        <input type="radio" name="r1"  value="0" class="minimal minimal_status" <?php if($customer->status == 0) echo 'checked=checked '; ?> /> Inactive
                      </label>
                      
                    </div>



                  </div>


                </div>

              </div><!-- /.box -->
             
            </div>
            <div class="col-md-6">
             <div class="box box-solid">
                <div class="box-header">
                  <h3 class="box-title">Invoices/Offers</h3>
                  <div class="btn-top-ryt">
                    <a href="{{tenant()->url('invoice/offer/add?id=')}}{{$customer->id}}" class="btn btn-primary btn-block btn-flat">New Offer
                    </a>
                    <a href="{{tenant()->url('invoice/bill/add?id=')}}{{$customer->id}}" class="btn btn-primary btn-block btn-flat">New Bill
                    </a>
                  </div>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12 col-sm-12">                 
                        <div class="table-responsive">
                          <table  id ="table-invoices" class="table table-striped">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Sum</th>
                                <th>Due date</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                           
                          </table>
                          <div class="total-block">
                            <span>Total Offers: <strong>{{$invoices['totaloffers']}}</strong></span>
                            <span>Total Bills: <strong>{{$invoices['totalbills']}}</strong></span>
                          </div>
                        </div><!-- /.col -->
                    </div>
                  </div>
                  
                </div>

            </div>
             
             
          </div>
     
          </div> 

          <div class="row">
            <div class="col-md-10">
              <div class="mail-wrap-section clearfix">
                <div class="col-md-5 bg-white">
                  <div class="box box-solid">
                    <div class="box-header">
                      <h3 class="box-title">Customers message</h3>                  
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <div class="row mailbox">
                        <div class="col-md-12 col-sm-12">
                            <div class="row pad pad-top-0">
                              
                              <div class="col-sm-12 search-form pad-5">
                                <form class="text-right" action="#">
                                  <div class="input-group">
                                     <input type="hidden" id="user_id" class="form-control input-sm " value="{{$customer->id}}">
                                    <input type="text" placeholder="Search" id="search_option" class="form-control input-sm">
                                    <div class="input-group-btn">
                                      <button class="btn btn-sm btn-primary" id="search-email" name="q" ><i class="fa fa-search"></i></button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div><!-- /.row -->
                       

                            <div class="table-responsive" id="email-list">
                              <!-- THE MESSAGES -->
                             <table class="table table-mailbox no-mg-btm">
                                <tbody>
                                   @foreach($mails as $mail)
                                   
                                   <tr class="e{{$mail->id}}">
                                      <td class="small-col"><!-- <i class="fa fa-reply"></i> -->
                                            @if($mail->status == 1)  {!!'<i class="fa fa-circle green"></i>'!!} @endif
                                            @if($mail->status == 2)  {!!'<i class="fa fa-circle red"></i>'!!} @endif
                                            @if($mail->status == 3)  {!!'<i class="fa fa-circle orange"></i>'!!} @endif
               {{--   @if($mail->status == 4)  {!!'<i class="fa fa-circle"></i>'!!} @endif --}}
                                    </td>
                                <td class="name">
           
                                 <?php $receiver = $mail->receiver;?>

              <a style="display: block" href="#" data-id="{{$mail->id}}" >
                  @foreach($receiver as $to)
                        @if($to->type ==1)
                           {{ str_limit($to->email,30)}};
                        @endif
                     @endforeach
                                  <small class="subject">{{str_limit($mail->subject,40)}}</small>
                                  </a> 
                                </td>
                                 
                                <td>

                              
                        @if(!empty($mail->attachment))
                           {!!'<i class="fa fa-paperclip grey"></i>'!!} 
                        @endif
                 
                                 


                                </td>

                                <td class="time"><small>{{email_date($mail->created_at)}}</small></td>
                              </tr>
                              @endforeach
                        </tbody>
                    </table>
                @if(empty($mails))
                    <p class="no-record">There is no email to show</p>
                @endif
                            </div><!-- /.table-responsive -->
                          </div><!-- /.col (RIGHT) -->
                         

                    </div>


                  </div><!-- /.box -->
                </div><!-- bg-white -->
@if($mails->total() > 1)

<p class="align-right">
<?php
$items = count($mails->items());
$to = ($mails->currentPage()-1) * $mails->perPage() + $items;
if($items >= $mails->perPage())
$from =  $to - $mails->perPage()+1;
else
$from =  $to - $mails->perPage()+1+($mails->perPage()-$items);
?>
<span class="color-grey">{{$from}}-{{$to}} of {{$mails->total()}}</span>
    @if($from !=1)
      <a href="#{{$mails->currentPage()-1}}" data class="mg-lr-5 mail-previous color-grey"><i class="fa  fa-chevron-left"></i></a>
    @endif
    @if($to != $mails->total())
      <a href="#{{$mails->currentPage()+1}}"  class="color-grey mail-next"><i class="fa  fa-chevron-right"></i></a>
    @endif
</p>
@endif

                </div>
             
                <div id="email-single" class="col-md-7 bg-white">
        
                </div><!-- bg-white -->

              </div>
              
            </div>
            <div id="customer-modal-data" class="hide">
            <div class="box box-solid">
              <div class="box-header">
                <h3 class="box-title">Update Customer</h3>
            </div>
          <div class="">
           
          </div>
      </div>
    </div>


     <!-- COMPOSE MESSAGE MODAL -->
<div class="modal modal-right fade" id="compose-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     role="dialog" aria-hidden="ture">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-envelope-o"></i> <span>Compose New Message</span></h4>
            </div>
                <div class="modal-body">
                 {!!Form::open(['url'=>url('desk/email/send'), 'id'=>'compose-form'])!!}
                 <input type="hidden" name="type" value="0" />
                    <div class="table-blk">
                        <div class="form-group disply-inline">
                        <div class="input-group">
                            <span class="input-group-addon">TO:</span>
                             {!! Form::text('email_to',$customer->email, ['id'=>'email_to','class'=>'form-control', 'placeholder'=>'Email To', 'autocomplete'=>'off']) !!}
                        </div>
                    </div>
                    <div class="form-group disply-inline">
                        <div class="input-group">
                            <span class="input-group-addon">CC:</span>
                           {!! Form::text('email_cc', null, ['id'=>'email_cc', 'class'=>'form-control', 'placeholder'=>'Email CC']) !!}
                        </div>
                    </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="input-group">
                            <span class="input-group-addon">Subject:</span>
                              {!! Form::text('subject', null, ['id'=>'subject','class'=>'form-control', 'placeholder'=>'']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                         <div class="input-group" style="width: 100%">
                           {!! Form::textarea('message', null, ['id'=>'message', 'class'=>'form-control textarea', 'placeholder'=>'Message', 'style'=>'height: 250px;']) !!}
                        </div>
                    </div>
                    <p class="align-right">
                        <a href="javascript:;" id="note-link"><i class="fa fa-plus"></i> Add note</a>
                    </p>
                    <div id="note-box" class="form-group">
                        <div class="input-group" style="width: 100%">
                          {!! Form::textarea('note', null, ['id'=>'note','class'=>'form-control', 'placeholder'=>'Note', 'style'=>'height: 70px;background: #FDFCBC;border: 1px solid #F8F7B6;box-shadow: 0 2px 1px rgba(0,0,0,.2);']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="container">
                            <a id="attachment" href="javascript:;" class="btn btn-success btn-file">
                                Attachment
                            </a>
                        </div>
                        <p class="help-block">Max. 20MB</p>
                         <div id='filelist'>Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
                    </div>


                    <div class="modal-footer clearfix text-align-left comp-footer">
                        <button type="button" class="btn btn-default pull-left sm-mg-btn" data-dismiss="modal"><i
                                class="fa fa-times"></i> Discard
                        </button>
                        <div  class="form-group f-width">
 
                            <div class="input-group input-custom">
                                    <span class="input-group-addon">Action:</span>
                                    <?php
                                     $status_list = [
                                             '' => 'Select',
                                             1 => 'Mark open',
                                             2 => 'Mark closed',
                                             3 => 'Mark pending',
                                             5 => 'Add to-do list'
                                         ];
                                    ?>
                                     {!! Form::select('status', $status_list, null, ['id'=>'status','class'=>'form-control']) !!}
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-email-submit pull-right"><i class="fa fa-envelope"></i> Send
                            Message
                        </button>
                     </div>

            {!! Form::close() !!}

           
<script type="text/javascript">
    $(function(){
        $('#note-link').click(function(){
            $('#note-box').slideToggle('fast');
        });

        $(".textarea").wysihtml5();

    });
 </script>

          </div>

          <script type="text/javascript">
        console.log(appUrl+'customer/changeStatus');
          $( ".minimal_status" ).click(function() {
            
            var cus_id = "{{$customer['id']}}";
            var token = "{{ csrf_token()}}";
            var url_to = appUrl+'customer/changeStatus';
            var status = $(this).val();
            $('.minimal_status').attr('disabled',true);
            $('.callout').remove();
            $.ajax({
            url: url_to,
            type: 'POST',
            dataType: 'json',
            data: {'status':status,'cus_id':cus_id,'_token':token},

          })
            .done(function (response) {
                if (response.status == true) {
                    $('.radio-box').after(notify('success', 'Status Changed Successfully'));
                    $('.minimal_status').attr('disabled',false);
                     setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                    
                }
                else {
                  alert('something went worng');
                   $('.minimal_status').attr('disabled',false);
                    }
            })
            .fail(function () {
                alert('something went wrong');
                 $('.minimal_status').attr('disabled',false);
            })
            .always(function () {
                
            });

        });


        $(document).on('click', '.btn-delete-customer_each', function (e) {
        e.preventDefault();
        var $this = $(this);

        var cus_id = "{{$customer['id']}}";
        var token = "{{ csrf_token()}}";
        var doing = false;

        if (!confirm('Are you sure, you want delete? This action will delete data permanently and can\'t be undo')) {
            return false;
        }

        if (cus_id != '' && doing == false) {
            doing = true;
           

            $.ajax({
                url: appUrl + 'customer/' + cus_id + '/delete',
                type: 'GET',
                dataType: 'json',
            })
                .done(function (response) {
                if(response.status == '0')
                {
                   alert('something went wrong');
                }

                if(response.status == '1'){
                    window.location.href=appUrl+'customer';
                } //success
                response.success
                })
                .fail(function () {
                    alert('something went wrong');
                    
                })
                .always(function () {
                    doing = false;
                });
        }

    });

          </script>
@stop