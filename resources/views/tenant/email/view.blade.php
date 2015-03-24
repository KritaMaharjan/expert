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
               {{ $to->email}};
            @endif
         @endforeach
     </p>

     <?php
     $has_cc = false;
      foreach($receiver as $cc):
          if($cc->type ==2):
            $has_cc = true;
            break;
          endif;
       endforeach;
     ?>
       @if($has_cc)
       <p><small class="color-blue"> CC: </small>
         @foreach($receiver as $cc)
             @if($cc->type ==2)
                {{ $cc->email  }};
             @endif
          @endforeach
          </p>
       @endif
    <div class="link-reply">
      <button data-toggle="dropdown" class="btn btn-default btn-sm btn-flat dropdown-toggle" type="button">
        Action <span class="caret"></span>
      </button>
      <ul role="menu" class="dropdown-menu">
         <li>
            <a href="#" data-type="<?php echo  $mail->type ? 'support' : 'personal' ;?>" title="Reply Email" data-original-title="Reply Email" data-toggle="modal" data-action="reply" data-id="<?php echo $mail->id;?>" data-target="#compose-modal"><small class="color-grey"><i class="fa fa-reply"></i></small> Reply</a>
         </li>
         <li>
            <a href="#" data-type="<?php echo  $mail->type ? 'support' : 'personal' ;?>" title="Forward Email" data-original-title="Forward Email"  data-toggle="modal" data-action="forward" data-id="<?php echo $mail->id;?>" data-target="#compose-modal"><small class="color-grey"><i class="fa fa-mail-forward"></i></small> Forward</a>
         </li>
         <li>
            <a href="#" title="Delete Email" class="email-delete" data-id="<?php echo $mail->id; ?>"><small class="color-grey"><i class="fa fa-close"></i></small> Delete</a>
         </li>
      </ul>
    </div>
    <hr/>
   <?php $attachments = $mail->attachments;?>
    @if(count($attachments)>0)
        <i class="fa fa-attach"></i> :
        @foreach($attachments as $file)
            <a target="_blank" href="{{$file->path()}}">{{$file->file}}</a>
        @endforeach
    <hr/>
    @endif
  </div><!-- /.box-header -->
  <div class="box-body">
        <?php echo nl2br($mail->message);?>
      <hr/>
       <p>Note :</p>
       <?php echo nl2br($mail->note);?>
  </div>
</div><!-- /.box -->

<?php endif;?>
