
   {!!Form::open(['id'=>'customer-form', 'files'=>true, 'enctype'=>'multipart/form-data'])!!}
                    <div class="box-body">
                      <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" placeholder="Name" name="name" value="{{$customer->name}}" id="name" class="form-control">
                        
                      </div>

                      <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" placeholder="Email" name="email" value="{{$customer->email}}" id="email" class="form-control">
                        
                      </div>
                   
                      <div class="form-group dob_div">
                        <label for="">Date of birth</label>
                        <?php $dob = explode("-",$customer->dob); ?>
                         <select name="day" class="form-control" id="day">
                            <?php for ($i = 1; $i <= 32; $i++): ?>
                                <option value='<?php echo $i; ?>' <?php if($i == $dob['2']) echo 'selected = selected'; ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select> 
                          <select name="month" class="form-control" id="month">
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value='<?php echo $i; ?>' <?php if($i == $dob['1']) echo 'selected = selected'; ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                          </select>
                        <?php
                           $now1 = Carbon::create();
                            $now2 = Carbon::create();
                            $min_year = $now1->subYears(80)->year;
                            $max_year = $now2->subYears(15)->year;
                        ?>

                        <select name="year" class="form-control" id="year">
                        <?php for ($i = $min_year; $i <= $max_year; $i++): ?>
                          <option <?php echo $i; ?> <?php if($i == $dob['0']) echo 'selected = selected'; ?> ><?php echo $i; ?></option>
                        <?php endfor; ?>
                        </select> 
                       
                      </div>
                  
                      <div class="form-group business_div">
                          <input type="text" placeholder="Company Number" name="company_number" value="{{$customer->company_number}}" class="form-control">
                      </div>
                 
                        <input type="hidden" name="type" id="type" value="{{$customer->type}}">
                      <div class="col-md-12 pad-0">
                        <div class="input-group">
                       
                          <input type="checkbox" name="business" id="business">Business
                        </div><!-- /input-group -->
                     </div>
                      <div class="form-group">
                        <label for="">Street name</label>
                        <input type="text" placeholder="Street Name"  id="street_name" name="street_name"  value="{{$customer->street_name}}" class="form-control">
                       
                      </div>
                       <div class="form-group">
                        <label for="">Street number</label>
                        <input type="text" placeholder="Street Number"  id="street_number" name="street_number"  value="{{$customer->street_number}}" class="form-control">
                     
                      </div>
                      <div class="form-group two-inputs">
                        <label for="">Postal code/Town</label>
                       
                         <input type="text" placeholder="postcode"  id="postcode" name="postcode"  value="{{$customer->postcode}}" class="form-control postal_code">
                        <input type="text" placeholder="Town"  id="town" name="town"  value="{{$customer->town}}" class="form-control city">
                    
                      </div>
                      <div class="form-group">
                        <label for="">Telephone</label>
                        <input type="text" placeholder="Telephone" id="telephone"  name="telephone" value="{{$customer->telephone}}" class="form-control">
                    
                      </div>
                      <div class="form-group">
                        <label for="">Mobile</label>
                        <input type="text" placeholder="Mobile" id="mobile" name="mobile" value="{{$customer->mobile}}" class="form-control">
                     
                      </div>
                     
                      <div class="form-group">
                        <label for="">Status</label>
                          {!! Form::select('status', 
                        [
                          '' => 'Select Status', 
                          '0' => 'Inactive',
                          '1' => 'Active',
                          
                        ], $customer->status, array('class' => 'form-control')) !!}
                      </div>
               

                   
                <div class="box-footer">
                    <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>    
                    <input type="submit" class="btn btn-primary customer-submit" value="Update" />
                </div>
                   
{!! Form::close() !!}

           <script type="text/javascript">
           $(function () {

           var modal = $('.modal-body');
           var type = $('#type').val();
           if(type == 1){
            modal.find('business').prop('checked',false);
             modal.find('.dob_div').show();
            modal.find('.business_div').hide();

           }else if(type == 2){

            modal.find('business').prop('checked',true);
             modal.find('.dob_div').hide();
            modal.find('.business_div').show();
           }


           var cache = {};
    $(".postal_code")
        // don't navigate away from the field on tab when selecting an item
        .bind("keydown", function (event) {
            if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 0,
            source: function(request, response) {
              requestURL =  appUrl+"postal/suggestions";
                // var term = request.term;
                // var token = '{{csrf_token()}}';
                // if (term in cache) {
                //     response(cache[ term ]);
                //     return;
                // }

                // $.ajax({
                //     url: appUrl+"postal/suggestions",
                //     type: "get",
                //     dataType: "json",
                //     data: {'data': term,'_token':token},
                //     success: function(data) {
                //       alert(data);
                      
                //         cache[ term ] = data;
                //         items1 = $.map(data, function(item) {

                //             return   {label: item.postcode +' , ' +item.town ,
                //                 value: item.postcode,
                //                 town :item.town ,
                //                 id: item.id}


                //         });
                //         response(items1);
                //     }
                // });

    var term = request.term;
                if (term in cache) {
                    response(cache[term]);
                    return;
                }
                $.getJSON(requestURL, {term: request.term}, function (data, status, xhr) {
                   cache[ term ] = data;
                         items1 = $.map(data, function(item) {

                            return   {label: item.postcode +' , ' +item.town ,
                                value: item.postcode,
                                town :item.town ,
                                id: item.id}


                        });

                        response(items1);
                });
            },
             //appendTo: '#customer-modal-data',
            search: function(event, ui) {
               
            },
            response: function(event, ui) {
               
            },
            create: function(event, ui) {
            },
            open: function(event, ui) {
               
            },
            focus: function(event, ui) {

            },
            _resizeMenu: function() {
                this.menu.element.outerWidth(200);
            },
            select: function(event, ui) {
                
                 var label = ui.item.town;
                 
                $('.city').val(label);
 

                

            }
        });
         });


           </script>

           