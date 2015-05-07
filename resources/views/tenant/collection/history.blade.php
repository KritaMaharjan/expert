@extends('tenant.layouts.main')

@section('heading')
Court History
@stop

@section('breadcrumb')
@stop


@section('content')
    <div class="box box-solid">
        <div class="box-body">
			        <div class="row">

			        <h5><strong>Collection steps:</strong></h5>

                    <ul>
                        @foreach($case->pdf as $pdf)
                            <li>{{$pdf}}</li>
                        @endforeach
                    </ul>


                     <h5><strong>Communication:</strong></h5>
                         @if(count($case->email) > 0)
                     <table class="table table-mailbox no-mg-btm">
                         @foreach($case->email as  $mail)
                             <tr class="e{{$mail->id}}">
                             <td class="name">
                               {!!Form::hidden('emails[]',$mail->id)!!}
                               <?php $receiver = $mail->receivers;?>
                               To:
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

                             </td>
                             <td class="time" style="text-align: right">
                             <small>{{email_date($mail->created_at)}}</small>
                             </td>
                             </tr>
                         @endforeach
                     </table>
                  @else
                    <p>There is no emails.</p>
                  @endif

                 <h5><strong>Additional Information:</strong></h5>
                    <p>{{$case->information}}</p>

        </div>
    </div>
@stop