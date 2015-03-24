<div class="modal modal-right fade" id="compose-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     role="dialog" aria-hidden="ture">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose New Message</h4>
            </div>
                <div class="modal-body">
                 {!!Form::open(['url'=>url('desk/email/send'), 'id'=>'compose-form'])!!}
                    <div class="form-group disply-inline">
                        <div class="input-group">
                            <span class="input-group-addon">TO:</span>
                             {!! Form::text('email_to', null, ['id'=>'email_to','class'=>'form-control', 'placeholder'=>'Email To', 'autocomplete'=>'off']) !!}
                        </div>
                    </div>
                    <div class="form-group disply-inline">
                        <div class="input-group">
                            <span class="input-group-addon">CC:</span>
                           {!! Form::text('email_cc', null, ['id'=>'email_cc', 'class'=>'form-control', 'placeholder'=>'Email CC']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Subject:</span>
                              {!! Form::text('subject', null, ['id'=>'subject','class'=>'form-control', 'placeholder'=>'']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                         <div class="input-group" style="width: 100%">
                           {!! Form::textarea('message', null, ['id'=>'message', 'class'=>'form-control', 'placeholder'=>'Message', 'style'=>'height: 120px;']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group" style="width: 100%">
                          {!! Form::textarea('note', null, ['id'=>'note','class'=>'form-control', 'placeholder'=>'Note', 'style'=>'height: 70px;']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="container">
                            <a id="attachment" href="javascript:;" class="btn btn-success btn-file">
                                Attachment
                            </a>
                        </div>
                        <p class="help-block">Max. 2MB</p>
                         <div id='filelist'>Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
                    </div>


                    <div class="modal-footer clearfix text-align-left">
                        <button type="button" class="btn btn-default pull-left sm-mg-btn" data-dismiss="modal"><i
                                class="fa fa-times"></i> Discard
                        </button>
                            <div  class="form-group">

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

                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-envelope"></i> Send
                            Message
                        </button>
                     </div>

            {!! Form::close() !!}

            @if($action == 'add')
                </div>
            </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->

@endif