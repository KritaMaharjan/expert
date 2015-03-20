<?php if(!empty($mail)):?>
<div class="box box-solid">
  <div class="box-header block-header">
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
        <li><a href="<?php echo url('desk/email/'.$mail->id.'/reply');?>"><small class="color-grey"><i class="fa fa-reply"></i></small> Reply</a></li>
        <li><a href="<?php echo url('desk/email/'.$mail->id.'/forward');?>"><small class="color-grey"><i class="fa fa-mail-forward"></i></small> Forward</a></li>
        <li><a href="<?php echo url('desk/email/'.$mail->id.'/delete');?>"><small class="color-grey"><i class="fa fa-close"></i></small> Delete</a></li>
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
</div><!-- /.box -->

<?php endif;?>
