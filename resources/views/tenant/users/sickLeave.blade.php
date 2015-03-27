<div class="box box-solid">
      <div class="box-header">
          <h3 class="box-title">Register Sick Leave</h3>
      </div>
      <div class="">
      {!! Form::open(array('method'=>'POST', 'id'=>'sick-form')) !!}
      
        <input type="hidden" name="user_id" id="user_id" value="{{ $User->id }}">
         <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="total" id="total" value="{{ $sick_leave_left }}">

           <div class="box-body">
              <h3 class="mg-top-0">Sick leave this year</h3>
              <p>
                <strong>Leave taken:</strong> <span id="sick_days"> {{ $sick_leave_left or '0'}} days </span> <span id="sick_used">{{ $sick_total or '0'}} used  </span> 
              </p> 
               <div class="table-responsive">
                  <!-- THE MESSAGES -->
                  <table class="table table-mailbox">
                     @if($allVacation)
                     @foreach($allVacation  as $vacation)
                     @if($vacation->sick_days != 0)
                    <tr>
                      <td width="40%" class="name">{{$vacation->from}} - {{$vacation->to}}</td>
                      
                      <td width="60%" class="subject position-relative">
                        <div class="action-buttons">
                          <a title="Delete" class="fa fa-close btn-danger pad-4 delete-leave" leave_id="{{$vacation->id}}" href="javascript:;"></a>                    
                        </div>
                        {{$vacation->sick_days}} day</td>
                    </tr>
                    @endif
                    @endforeach
                     @endif
                </table>
              <p class="align-right">  
              <a href="javascript:;" id="add_sick_leave" class="btn btn-primary">Add Vacation </a>
            </p>


            </div><!-- /.box-body -->

          <div id="add_part" style="display:none">
           <div class="form-group two-inputs">
              <input class="form-control" name="from" id="from" value="" placeholder="From">
              <input class="form-control" name="to" id="to" value="" placeholder="To">
            </div>

        <div class="box-footer clearfix">
         <button type="button" class="btn sm-mg-btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
          {!! Form::button('Save', array('class'=>'btn btn-primary pull-right saveleave', 'type'=>'submit')) !!}
        </div>
      </div>
      {!! Form::close() !!}
    </div>
    </div>
  </div>

  <script type="text/javascript">
  $(document).on('click', '#add_sick_leave', function (e) {
    $('#add_part').show();
  });


  $("#from").datepicker({
              'format': 'yyyy-mm-dd',
        onSelect: function(date) {
          
            

        },  
        onClose: function( selectedDate ) {
            $( "#to" ).datepicker( "option", "minDate", selectedDate );
        } 

         });
 $("#to").datepicker({
            'format': 'yyyy-mm-dd',
        onSelect: function(date) {
           
            

        },  
        onClose: function( selectedDate ) {
           
        } 
         });

  $(document).on('click', '.saveleave', function (e) {
        e.preventDefault();

      
       var _token = $('#_token').val();
       var user_id = $('#user_id').val();
       var vacation_days = $('#total').val();
        var from = $('#from').val();
         var to = $('#to').val();
        var type = 'sick_days';
        
       
           $.ajax({
            url: appUrl + 'user/addVacation',
            type: 'POST',
            dataType: 'json',
            data: {'_token':_token,'user_id':user_id,'vacation_days':vacation_days,'type':type,'from':from,'to':to},
             async: false,
                 success: function(response) {
                    if (response.status == true) {

                  $('#sick_days').text(response.vacation_days+'days');
                   $('#sick_used').text(response.vacation_used+'days');
                   $('.table-mailbox').append('<tr><td width="40%" class="name">'+from +'-'+ to +'</td><td width="60%" class="subject position-relative"><div class="action-buttons"><a title="Delete" class="fa fa-close btn-danger pad-4 delete-leave" href="javascript:;"></a></div> '+response.leave_taken+' day</td></tr>');

                    $('#add_part').hide();
                    $('#from').val('');
                    $('#to').val('');
                    
                    
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);


                }
                else {
                  $('.two-inputs').after('<label class="error">Leave cannot be more than estimated vacation</label');
                   
                }

                 }
        });
            
    });


$(document).on('click', '.delete-leave', function () {
    $('#add_part').show();
     var leave_id = $(this).attr('leave_id');
       var _token = $('#_token').val();
        $this = $(this);
        var answer = confirm("Do you sure want to delete this?");
      if (answer){
         $.ajax({
           url: appUrl + 'user/deleteVacation',
            type: 'POST',
            dataType: 'json',
            data: {'_token':_token,'leave_id':leave_id},
             async: false,
                 success: function(response) {
                  if (response.status == true) {
                       $this.closest('tr').remove();
                    }
                 }
         });
      }else{

      }
  });
     

  </script>