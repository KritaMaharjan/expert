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
                        <select class="form-control js-example-basic-multiple postcode"  placeholder="Postal code" id="postcode" name="postcode"  value="{{old('postcode')}}">
                          <option value="{{$customer->postcode}}">{{$customer->postcode}}</option>
                      
                        </select>
                        <input type="text" placeholder="Town"  id="town" name="town"  value="{{$customer->town}}" class="form-control">
                    
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
                    <div class="form-group">
                        <label>Upload Photo</label>
                        <div class="">
                            <input type="file" name="photo" id="photo">
                        </div>
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
         });


           </script>

           <script type="text/javascript">
             $(document).ready(function () {

               var customerSelect = $(".js-example-basic-multiple");
    customerSelect.select2({

        ajax: {
            url: appUrl + 'postal/suggestions',
            dataType: 'json',
            cache: false,
            selectOnBlur: true,
            data: function (params) {
                return {
                    postcode: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data) {

                return {
                    results: $.map(data, function (obj) {
                        return {id: obj.text, text: obj.text};
                    })
                };
            }
        },
        formatResult: FormatResult,
        formatSelection: FormatSelection,
        escapeMarkup: function (m) {
            return m;
        }
    })
     $(document.body).on("change",".js-example-basic-multiple",function(){

 var value = this.value;
 var test = value.split(','); 

 $('#town').val(test[1]);
 $('span #select2-postcode-container').text(test[0]);


 
});



function FormatResult(item) {
    var markup = "";
    if (item.text !== undefined) {
        markup += "<option value='" + item.text + "'>" + item.text + "</option>";
    }
    return markup;
}

function FormatSelection(item) {
    console.log(item.text)
    return item.text;
}
});

</script>