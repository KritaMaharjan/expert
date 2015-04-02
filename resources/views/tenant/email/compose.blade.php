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
                    <div class="table-blk">
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

            @if($action == 'add')
                </div>
            </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif

<script type="text/javascript">
    $(function(){
        $('#note-link').click(function(){
            $('#note-box').slideToggle('fast');
        });
        $(".textarea").wysihtml5();
    });
</script>