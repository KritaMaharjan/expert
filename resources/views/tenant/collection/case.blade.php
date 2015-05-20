
    <div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">Court Case</h3>
    </div>

      <div class="callout callout-info">
    	    <p>Creating a court case is easy just follow the steps below and we'll create all the documents you need to fill out. We have even completed step 1 for you already!</p>
    	</div>

        <div class="box-body">
        {!!Form::open(['url'=>tenant()->url('collection/court-case/create')])!!}

        {!!Form::hidden('bill',$bill)!!}
            <div class="row">
            	<div class="col-md-12">
            		<ol class="pad-left-20">
            			<li>
            				<p>To the document that you have followed the required steps in the collection process we have added the bill and late payment notices you have sent:</p>
            				<ul class="pad-0 imgaes-row">
            					@foreach($pdf as $name => $file )
            					<li>
                                    <?php
                                    $arr = explode('/', $file);
                                    $filename = end($arr);
                                    ?>
                                   {!!Form::hidden('pdf[]',$filename)!!}
            						<i class="fa fa-file"></i>
            						<span class="text-middle"><a href="{{$file}}" target="_blank">{{$name}}.pdf</a></span>
            					</li>
            					@endforeach
            				</ul>
        				</li>
        			{{--	<li>
        					<p>It's important to document the contract, order forms and other documentation:</p>
        					<div class="list-bx">
        						<p><strong>List of documents on customer card</strong></p>

	        					<ul class="pad-left-20">
	        						<li>List 1</li>
	        						<li>List 2</li>
	        						<li>List 3</li>
	        					</ul>
        					</div>
        					<p>Select other to add</p>

        				</li>--}}
        				<li>
        					<p>Now let's make the case stick by adding all the communication relevant for the case</p>
        					<div class="list-bx" style="padding: 0px" >
        					@if($emails->count() > 0)
                                <table class="table table-mailbox no-mg-btm">
                                    @foreach($emails as  $mail)
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
                               <p style="margin: 10px">There is no emails.</p>
                             @endif
        					</div>
        				</li>
        				<li>
        					<p>Now let's make the case stick by adding all the communication relevant for the case</p>
        					<textarea class="list-bx" name="information" placeholder="Write an explanation here about what happened"></textarea>
        				</li>
            		</ol>
            		<p class="col-md-6 align-right">
            		    <button class="btn btn-primary" type="submit">Create</button>
            			<a href="#"  data-dismiss="modal" aria-hidden="true" class="btn btn-danger" title="Cancel">Cancel</a>
            		</p>
            	</div>
        	</div>
        {!!Form::close()!!}
        </div>
    </div>
