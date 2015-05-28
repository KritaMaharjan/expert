<?php if(!empty($mail)):?>
<div class="box box-solid">
  <div class="box-header block-header">
    <h3 class="box-title"><strong><?php echo $mail->subject;?></strong>
    </h3>
    <p><small class="color-blue">Sent: </small> <?php echo $mail->created_at->format('D m/d/Y h:i A');?></p>
     <?php $receiver = $mail->receivers;?>
     <p><small class="color-blue"> To: </small>
        @if($folder == 0)
            @foreach($receiver as $to)
                @if($to->type ==1)
                   {{ $to->email}};
                @endif
             @endforeach
         @else
            {{ $mail->from_email}};
         @endif
     </p>

     <?php $has_cc = false; ?>
     @if($folder == 0)
         @foreach($receiver as $cc)
            @if($cc->type ==2)
              <?php $has_cc = true;?>
            @endif
         @endforeach
      @endif

       @if($has_cc)
       <p><small class="color-blue"> CC: </small>
         @foreach($receiver as $cc)
             @if($cc->type ==2)
                {{ $cc->email  }}
             @endif
          @endforeach
          </p>
       @endif
    <div class="link-reply">
      <button data-toggle="dropdown" class="btn btn-default btn-sm btn-flat dropdown-toggle" type="button">
        Action <span class="caret"></span>
      </button>
      <ul role="menu" class="dropdown-menu pos-right">
         <li>
            <a href="#" data-type="<?php echo  $mail->type ? 'support' : 'personal' ;?>" title="Reply Email" data-original-title="Reply Email" data-toggle="modal" data-action="reply" data-id="{{ $mail->id }}" data-target="#compose-modal" folder="{{ $folder }}"><small class="color-grey"><i class="fa fa-reply"></i></small> Reply</a>
         </li>
         <li>
            <a href="#" data-type="<?php echo  $mail->type ? 'support' : 'personal' ;?>" title="Forward Email" data-original-title="Forward Email"  data-toggle="modal" data-action="forward" data-id="<?php echo $mail->id;?>" data-target="#compose-modal" folder="{{ $folder }}"><small class="color-grey"><i class="fa fa-mail-forward"></i></small> Forward</a>
         </li>
         <li>
            <a href="#" folder = "{{$folder}}" title="Delete Email" class="email-delete" data-id="<?php echo $mail->id; ?>"><small class="color-grey"><i class="fa fa-close"></i></small> Delete</a>
         </li>
      </ul>
    </div>
    <hr/>
   <?php $attachments = $mail->attachments;?>
    @if(count($attachments)>0)
        <i class="fa fa-paperclip"></i> :
        @foreach($attachments as $file)
            <a target="_blank" href="{{$file->path()}}">{{$file->file}}</a>
        @endforeach
    <hr/>
    @endif
  </div><!-- /.box-header -->
  <div class="box-body" style="overflow-x: auto">
        @if($folder == 0)
            {!! $mail->message !!}
        @else
            {!! $mail->body_html !!}
        @endif
      <hr/>
      @if($mail->note)
       <label>Note :</label>
       <div class="note-box-yellow">
        <?php echo nl2br($mail->note);?>
        </div>
        @endif
  </div>
</div><!-- /.box -->

<?php endif;?>
