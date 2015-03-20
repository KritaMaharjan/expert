<div class="box box-solid">
      <div class="box-header">
          <h3 class="box-title">Register Vacation</h3>
      </div>
      <div class="">
      {!! Form::open(array('method'=>'POST', 'files'=>true, 'id'=>'vacation-form')) !!}
      
        <input type="hidden" name="user_id" id="user_id" value="{{ $User->id }}">
         <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="vacationtotal" id="vacationtotal" value="{{ $vacationDays['vacation_days'] }}">

           <div class="box-body">
              Vacation days left this year: <span id="vacation_days"> {{ $vacationDays['vacation_days'] or '0'}} days </span> <span id="vacation_used">{{$vacation['vacation_days'] or '0'}} used  </span>  
              <br>
              <a href="javascript:;" id="add_vacation">Add Vacation </a>


            </div><!-- /.box-body -->

          <div id="add_part" style="display:none">
            <input name="vacation" id="leave" value="" />

        <div class="box-footer clearfix">
           <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
          {!! Form::button('Save', array('class'=>'btn btn-primary pull-right saveVacation', 'type'=>'submit')) !!}
        </div>
      </div>
      {!! Form::close() !!}
    </div>
    </div>
  </div>

  <script type="text/javascript">
  $(document).on('click', '#add_vacation', function (e) {
    $('#add_part').show();
  });

  $(document).on('click', '.saveVacation', function (e) {
        e.preventDefault();

      var days = $('#leave').val();
       var _token = $('#_token').val();
       var user_id = $('#user_id').val();
       var vacation_days = $('#vacationtotal').val();
        $.ajax({
            url: appUrl + 'user/addVacation',
            type: 'POST',
            dataType: 'json',
            data: {'days':days,'_token':_token,'user_id':user_id,'vacation_days':vacation_days}
        })
            .done(function (response) {
                if (response.status === 1) {

                  $('#vacation_days').text(response.vacation_days+'days');
                   $('#vacation_days').text(response.vacation_used+'days');
                    $('#fb-modal').modal('hide');
    
                    
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
                else {

                   
                }
            })
            .fail(function () {
                alert('something went wrong');
            })
            .always(function () {
               
            });
    });
   
     

  </script>