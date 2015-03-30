
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