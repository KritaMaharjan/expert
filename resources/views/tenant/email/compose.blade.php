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
                            <select  class="select-multiple form-control" multiple="multiple">
                            </select>
                          {{--   {!! Form::text('email_to', null, ['class'=>'form-control', 'placeholder'=>'Email To']) !!} --}}
                        </div>
                    </div>
                    <div class="form-group disply-inline">
                        <div class="input-group">
                            <span class="input-group-addon">CC:</span>
                           {!! Form::text('email_cc', null, ['class'=>'form-control', 'placeholder'=>'Email CC']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Subject:</span>
                              {!! Form::text('subject', null, ['class'=>'form-control', 'placeholder'=>'']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                    {!! Form::textarea('message', null, ['class'=>'form-control', 'placeholder'=>'Message', 'style'=>'height: 120px;']) !!}
                    </div>
                    <div class="form-group">
                    {!! Form::textarea('note', null, ['class'=>'form-control', 'placeholder'=>'Note', 'style'=>'height: 70px;']) !!}
                    </div>
                    <div class="form-group">
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
                            <select class="form-control">
                                <option>Mark open</option>
                                <option>Mark closed</option>
                                <option>Mark pending</option>
                                <option>Select from list of coworkers</option>
                                <option>Add to-do list</option>
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

 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <style>
  .ui-autocomplete-loading {
    background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
  }
  </style>
<script>

$(function(){

var requestURL = appUrl  + '/customer/list'


   function split( val ) {
        return val.split( /,\s*/ );
      }
      function extractLast( term ) {
        return split( term ).pop();
      }

      $( ".select-multiple" )
        // don't navigate away from the field on tab when selecting an item
        .bind( "keydown", function( event ) {
          if ( event.keyCode === $.ui.keyCode.TAB &&
              $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
          }
        })
        .autocomplete({
          source: function( request, response ) {
            $.getJSON( requestURL, {
              term: extractLast( request.term )
            }, response );
          },
          search: function() {
            // custom minLength
            var term = extractLast( this.value );
            if ( term.length < 2 ) {
              return false;
            }
          },
          focus: function() {
            // prevent value inserted on focus
            return false;
          },
          select: function( event, ui ) {
            var terms = split( this.value );
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.value );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( ", " );
            return false;
          }
        });
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