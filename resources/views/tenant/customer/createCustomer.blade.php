
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
                      <div class="form-group business_div">
                            <input type="text" placeholder="Company Number" name="company_number" value="{{old('company_number')}}" class="form-control">
                      </div>
                      <input type="hidden" name="type" id="type" value="1">
                    <div class="col-md-12 pad-0">
                      <div class="input-group">
                            <input type="checkbox" name="business" id="business"> Business
                      </div><!-- /input-group -->
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
                        <input type="text" placeholder="Postal code" id="postcode" name="postcode"  value="{{old('postcode')}}" class="form-control">
                        <input type="text" placeholder="Town"  id="town" name="town"  value="{{old('town')}}" class="form-control">
                    
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
                       <div id="fineuploader">
                       </div>
                      <div class="form-group">
                        <label>Upload Photo</label>
                        <div class="@if($errors->has('photo')) {{'has-error'}} @endif">
                          <input type="file" name="photo" id="photo">
                         
                        </div>
                      </div> 
                       <div class="form-group">
                        
                      
                        
                      </div>
                   
                    <div class="box-footer">
                        <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
                        <input type="submit" class="btn btn-primary customer-submit" value="Add" />
                    </div>
                   
           {!! Form::close() !!}

<script type="text/javascript">
$(function(){
   $('#fineuploader').fineuploader({
    
   })
})
</script>


 <script type="text/template" id="qq-template">
  <div class="qq-uploader-selector qq-uploader">
    <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
      <span>Drop files here to upload</span>
    </div>
    <div class="qq-upload-button-selector qq-upload-button">
      <div>Upload a file</div>
    </div>
    <span class="qq-drop-processing-selector qq-drop-processing">
      <span>Processing dropped files...</span>
      <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
    </span>
    <ul class="qq-upload-list-selector qq-upload-list">
      <li>
        <div class="qq-progress-bar-container-selector">
          <div class="qq-progress-bar-selector qq-progress-bar"></div>
        </div>
        <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
        <span class="qq-edit-filename-icon-selector qq-edit-filename-icon"></span>
        <span class="qq-upload-file-selector qq-upload-file"></span>
        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
        <span class="qq-upload-size-selector qq-upload-size"></span>
        <a class="qq-upload-cancel-selector qq-upload-cancel" href="#">Cancel</a>
        <a class="qq-upload-retry-selector qq-upload-retry" href="#">Retry</a>
        <a class="qq-upload-delete-selector qq-upload-delete" href="#">Delete</a>
        <span class="qq-upload-status-text-selector qq-upload-status-text"></span>
      </li>
    </ul>
  </div>
</script>

 