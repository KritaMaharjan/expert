<div class="modal modal-right fade" id="compose-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     role="dialog" aria-hidden="ture">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-envelope-o"></i> Compose New Message</h4>
            </div>

            {!!Form::open(['url'=>url('desk/email/send'), 'id'=>'compose-form'])!!}

                <div class="modal-body">

                    <div class="form-group disply-inline">
                        <div class="input-group">
                            <span class="input-group-addon">TO:</span>
                            <select name="email_to[]" class="js-example-basic-multiple" multiple="multiple">
                            </select>
                          {{--   {!! Form::text('email_to', null, ['class'=>'form-control', 'placeholder'=>'Email To']) !!} --}}
                        </div>
                    </div>
                    <div class="form-group disply-inline">
                        <div class="input-group">
                            <span class="input-group-addon">CC:</span>
                             <select name="email_cc[]" class="js-example-basic-multiple" multiple="multiple">
                            </select>
                          {{--  {!! Form::text('email_cc', null, ['class'=>'form-control', 'placeholder'=>'Email CC']) !!} --}}
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <div class="input-group">
                            <span class="input-group-addon">BCC:</span>
                             <select name="email_bcc[]" class="js-example-basic-multiple" multiple="multiple">
                            </select>
                          {{--  {!! Form::text('email_bcc', null, ['class'=>'form-control', 'placeholder'=>'Email BCC']) !!} --}}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Subject:</span>
                              {!! Form::text('subject', null, ['class'=>'form-control', 'placeholder'=>'']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                    {!! Form::textarea('message', null, ['class'=>'form-control', 'placeholder'=>'message', 'style'=>'height: 120px;']) !!}
                    </div>
                    <div class="form-group">
                    {!! Form::textarea('note', null, ['class'=>'form-control alert alert-lightgreen', 'placeholder'=>'Note', 'style'=>'height: 70px;']) !!}
                    </div>
                    <div class="form-group">
                        <input name="attachment" id="attachment_img" name="attch" value=""/>
                        <div id="container">
                            <a id="attachment" href="javascript:;" class="btn btn-success btn-file">
                                Attachment
                            </a>
                        </div>
                        <p class="help-block">Max. 32MB</p>
                        <div id='filelist'>Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
                        <pre id='console'></pre>
                    </div>


                    <div class="modal-footer clearfix text-align-left">
                        <button type="button" class="btn btn-default pull-left sm-mg-btn" data-dismiss="modal"><i
                                class="fa fa-times"></i> Discard
                        </button>
                        <div class="input-group input-custom">
                            <span class="input-group-addon">Action:</span>
                            <select name="status" class="form-control">
                                <option value="1">Mark open</option>
                                <option value="2">Mark closed</option>
                                <option value="3">Mark pending</option>
                                <option value="4">Select from list of coworkers</option>
                                <option value="5">Add to-do list</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-envelope"></i> Send
                            Message
                        </button>
                    </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>

$(function(){

    $(".js-example-basic-multiple").select2({

      ajax: {
        url: appUrl+'desk/email/customers',
        dataType: 'json',
         data: function (params) {
          return {
            email_to : params.term, // search term
            page: params.page
          };
        },
        processResults: function (data) {
            
            return {
                results: $.map(data, function(obj) {
                    return { id: obj.email, text: obj.email };
                })
            };
        }
    },
    tags: true
    });


    $(document).on('submit', '#compose-form', function(e){
        e.preventDefault();

        var form = $(this);
        var action = form.attr('action');

            $.ajax({
                url: action ,
                type: 'POST',
                dataType: 'json',
                data: form.serialize()
            })
            .done(function(response) {
                console.log(response);
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });

    });

});
</script>