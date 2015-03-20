<div class="table-responsive fix-height" style="background: #FDFDFD; border: 1px solid #F8F8F8;">
<!-- THE MESSAGES -->
<table class="table table-mailbox no-mg-btm">
    <tbody>
          @foreach($mails as $mail)
          <tr class="unread">
            <td class="small-col"><i class="fa fa-envelope"></i></td>
            <td class="name">
             <?php $receiver = $mail->receivers;?>
              <a href="#">
                    @foreach($receiver as $to)
                        @if($to->type ==1)
                           {{ '('.$to->customer_id.') '. $to->email}};
                        @endif
                     @endforeach
                <small class="subject">{{$mail->subject}}</small>
              </a>
            </td>
            <td class="time">{{$mail->created_at->diffForHumans()}}</td>
          </tr>
          @endforeach
    </tbody>
</table>
@if($mails->total() < 1)
    <p class="no-record">There is no email to show</p>
@endif
</div><!-- /.table-responsive -->
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
  <a href="#next" class="mg-lr-5  color-grey"><i class="fa  fa-chevron-left"></i></a>
  <a href="#previous" class="color-grey"><i class="fa  fa-chevron-right"></i></a>
</p>

