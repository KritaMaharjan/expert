<div class="table-responsive fix-height" style="background: #FDFDFD; border: 1px solid #F8F8F8;">
<!-- THE MESSAGES -->
<table class="table table-mailbox no-mg-btm">
    <tbody>
          @foreach($mails as $mail)
          <tr class="e{{$mail->id}}">
            @if(isset($mail->status))
            <td class="small-col"><!-- <i class="fa fa-reply"></i> -->
              @if($mail->status == 1)  {!!'<i class="fa fa-circle green"></i>'!!} @endif
               @if($mail->status == 2)  {!!'<i class="fa fa-circle red"></i>'!!} @endif
                @if($mail->status == 3)  {!!'<i class="fa fa-circle orange"></i>'!!} @endif
               {{--   @if($mail->status == 4)  {!!'<i class="fa fa-circle"></i>'!!} @endif --}}
            </td>
            @endif
            <td class="name">
              <?php $receiver = $mail->receivers;?>
              <a style="display: block" href="#" data-id="{{$mail->id}}" folder="{{ $folder }}" >
                @if(isset($mail->from_email))
                    {{$mail->from_email}}
                @else
                    @foreach($receiver as $to)
                        @if($to->type ==1)
                           {{ str_limit($to->email,30)}}
                        @endif
                    @endforeach
                @endif
                <small class="subject">{{str_limit($mail->subject,20)}}</small>
              </a>
            </td>
            <td> @if(!empty($mail['attachments']->file)) {!!'<i class="fa fa-paperclip grey"></i>'!!} @endif</td>

            <td class="time"><small>{{email_date($mail->created_at)}}</small></td>
          </tr>
          @endforeach
    </tbody>
</table>
@if($mails->total() < 1)
    <p class="no-record">There is no email to show</p>
@endif
</div><!-- /.table-responsive -->


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

@if(isset($connection_errors))
    <div class="callout callout-danger">
        {{--{{ $errors }}--}}
        <?php print_r($connection_errors) ?>
    </div>
@endif
