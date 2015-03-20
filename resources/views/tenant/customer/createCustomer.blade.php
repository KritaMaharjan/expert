{!!Form::open(['id'=>'customer-form', 'enctype'=>'multipart/form-data','files'=>true])!!}
                    <div class="box-body">
                      <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" placeholder="Name" name="name" value="" id="name" class="form-control">
                        
                      </div>
                       <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" placeholder="Email" name="email" value="" id="email" class="form-control">
                        
                      </div>
                      <div class="form-group business_div">
                            <input type="text" placeholder="Company Number" name="company_number" value="{{old('company_number')}}" class="form-control">
                      </div>
                      <input type="hidden" name="type" id="type" value="1">
                    <div class="col-md-12 pad-0">
                      <div class="input-group">
                            <input type="checkbox" name="business" id="business"> <strong>Business</strong>
                      </div><!-- /input-group -->
                    </div>
                      <div class="form-group dob_div">
                        <label for="">Date of birth</label>
                       <select name="day" class="form-control" id="day">
                            <?php for ($i = 1; $i <= 32; $i++): ?>
                                <option value='<?php echo $i; ?>'><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select> 
                      <select name="month" class="form-control" id="month">
                            <?php foreach ($months as $num => $name) { ?>
                                <option value='<?php echo $num; ?>'><?php echo $name; ?></option>
                            <?php } ?>
                      </select>
                        <?php
                           $now1 = Carbon::create();
                            $now2 = Carbon::create();
                            $min_year = $now1->subYears(80)->year;
                            $max_year = $now2->year;
                        ?>

                      <select name="year" class="form-control" id="year">
                        <?php for ($i = $min_year; $i <= $max_year; $i++): ?>
                        <option <?php echo $i; ?> ><?php echo $i; ?></option>
                        <?php endfor; ?>
                      </select> 
                       
                      </div>
                      <div class="form-group">
                        <label for="">Street name</label>
                        <input type="text" placeholder="Street Name"  id="street_name" name="street_name"  value="{{old('street_name')}}" class="form-control">
                       
                      </div>
                       <div class="form-group">
                        <label for="">Street number</label>
                        <input type="text" placeholder="Street Number"  id="street_number" name="street_number"  value="{{old('street_number')}}" class="form-control">
                     
                      </div>
                      <div class="form-group two-inputs">
                        <label for="">Postal code/Town</label>


                        <select class="form-control js-example-basic-multiple"  placeholder="Postal code" id="postcode" name="postcode"  value="{{old('postcode')}}">
                       
                        </select>

                        <input type="text" placeholder="Town"  id="city" name="town"  value="{{old('town')}}" class="form-control">

                    
                      </div>
                      <div class="form-group">
                        <label for="">Telephone</label>
                        <input type="text" placeholder="Telephone" id="telephone"  name="telephone" value="{{old('telephone')}}" class="form-control">
                    
                      </div>
                      <div class="form-group">
                        <label for="">Mobile</label>
                        <input type="text" placeholder="Mobile" id="mobile" name="mobile" value="{{old('mobile')}}" class="form-control">
                     
                      </div>
                     
                      <div class="form-group">
                        <label for="">Status</label>
                         <select name="status" class="form-control" id="status">
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select> 
                      </div>
                       
                      <div class="form-group">
                        <label>Upload Photo</label>
                        <div class="@if($errors->has('photo')) {{'has-error'}} @endif">
                          <input type="file" name="photo" id="photo">
                         
                        </div>
                      </div> 
                       
                      
                        
                      </div>
                   
                    <div class="box-footer">
                        <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
                        <input type="submit" class="btn btn-primary customer-submit" value="Add" />
                    </div>
                   
           {!! Form::close() !!}

<script type="text/javascript">
<<<<<<< HEAD
$(function(){
   $('.select2-postcodes-container').hide();
   $(".js-example-basic-multiple").select2({

      ajax: {
        url: appUrl+'postal/suggestions',
        dataType: 'json',
        cache:false,
         data: function (params) {
          return {
            postcode: params.term, // search term
            page: params.page
          };
        },
        processResults: function (data) {
            
            return {
                results: $.map(data, function(obj) {
                    return { id: obj.text, text: obj.text};
                })
            };
        }
    },
   
    })
})
=======
  $(document).ready(function () {
    $(".js-example-basic-multiple").select2({

        ajax: {
            url: appUrl + 'postal/suggestions',
            dataType: 'json',
            cache: false,
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

//     $(".js-example-basic-multiple").change(function() {
//     //var theID = $(test).val(); // works
//     //var theSelection = $(test).filter(':selected').text(); // doesn't work
//     var theID = $(".js-example-basic-multiple").select2('data').id;
//     var theSelection = $(".js-example-basic-multiple").select2('data').text;
//     alert(theID);
//     // $('#selectedID').text(theID);
//     // $('#selectedText').text(theSelection);
// });


>>>>>>> b811d6f4be0341cdd4afce61ad8cc4cfd6149f02
</script>