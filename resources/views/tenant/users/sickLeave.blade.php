<div class="box box-solid">
      <div class="box-header">
          <h3 class="box-title">Register Sick Leave</h3>
      </div>
      <div class="">
      {!! Form::open(array('method'=>'POST', 'id'=>'sick-form')) !!}
      
        <input type="hidden" name="user_id" id="user_id" value="{{ $User->id }}">
         <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="sicktotal" id="sicktotal" value="{{ $sick_leave_left }}">

           <div class="box-body">
              <h3 class="mg-top-0">Sick leave this year</h3>
              <p>
                <strong>Leave taken:</strong> <span id="sick_days"> {{ $sick_leave_left or '0'}} days </span> <span id="sick_used">{{ $sick_total or '0'}} used  </span> 
              </p> 
               <div class="table-responsive">
                  <!-- THE MESSAGES -->
                  <table class="table table-mailbox">
                    <tr>
                      <td class="name">March 1</td>
                      <td class="subject postion-relative">
                        <div class="action-buttons">
                          <a href="#" class="fa fa-close"></a>
                        </div>
                        1 day</td>
                    </tr>
                    <tr>
                      <td class="name">March 5-6</td>
                      <td class="subject">2 day</td>
                    </tr>
                </table>
              <p class="align-right">  
              <a href="javascript:;" id="add_sick_leave" class="btn btn-primary">Add Vacation </a>
            </p>


            </div><!-- /.box-body -->

          <div id="add_part" style="display:none">
           <div class="form-group two-inputs">
              <input class="form-control" name="vacation" id="leave" value="" placeholder="From">
              <input class="form-control" name="vacation" id="leave" value="" placeholder="To">
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

  $(document).on('click', '.saveleave', function (e) {
        e.preventDefault();

      var days = $('#leave').val();
       var _token = $('#_token').val();
       var user_id = $('#user_id').val();
       var vacation_days = $('#sicktotal').val();
        var type = 'sick_days';
        if(days > vacation_days){
          $('#leave').after('<label class="error ">Vacation cannot be more than estimated</label>');

        }else{
           $.ajax({
            url: appUrl + 'user/addVacation',
            type: 'POST',
            dataType: 'json',
            data: {'days':days,'_token':_token,'user_id':user_id,'vacation_days':vacation_days,'type':type},
             async: false,
                 success: function(response) {
                    if (response.status == true) {

                  $('#sick_days').text(response.vacation_days+'days');
                   $('#sick_used').text(response.vacation_used+'days');
                    
                    
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
                else {

                   
                }

                 }
        });

        }

            
    });
   
     

  </script>