<div class="box-body">
    <div class="form-group">
      @if(isset($mode) && $mode == 'edit')
        <img src="{{ ($user->photo  && file_exists(base_path('public_html/assets/uploads/'.$user->photo)))? asset('assets/uploads/'.$user->photo) : asset('assets/images/no_image.jpg') }}" class="image-uplod" />
      @endif
      <label>Upload Photo</label>
      <div class="@if($errors->has('photo')) {{'has-error'}} @endif">
        {!! Form::file('photo') !!}
      </div>
    </div>

    <div class="form-group">
      <label for="fullname">Name</label>
      <div class="@if($errors->has('fullname')) {{'has-error'}} @endif">
        {!!Form::text('fullname', NULL, array('class' => 'form-control', 'id' => 'fullname'))!!}  
      </div>
    </div>

    @if(!isset($mode))
    <div class="form-group">
      <label for="password">Password</label>
      <div class="@if($errors->has('password')) {{'has-error'}} @endif">
        {!!Form::password('password', array('class' => 'form-control', 'id' => 'password'))!!}  
      </div>
    </div>

    <div class="form-group">
      <label for="confirm_password">Confirm Password</label>
      <div class="@if($errors->has('confirm_password')) {{'has-error'}} @endif">
        {!!Form::password('confirm_password', array('class' => 'form-control', 'id' => 'confirm_password'))!!}  
      </div>
    </div>
    @endif

    <div class="form-group">
      <label for="social_security_number">Social Security Number</label>
      <div class="@if($errors->has('social_security_number')) {{'has-error'}} @endif">
        {!!Form::text('social_security_number', NULL, array('class' => 'form-control', 'id' => 'social_security_number'))!!}  
      </div>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <div class="@if($errors->has('email')) {{'has-error'}} @endif">
        {!!Form::email('email', NULL, array('class' => 'form-control', 'id' => 'email'))!!}  
      </div>
    </div>

    <div class="form-group">
      <label for="phone">Phone</label>
      <div class="@if($errors->has('phone')) {{'has-error'}} @endif">
        {!!Form::text('phone',NULL, array('class' => 'form-control', 'id' => 'phone'))!!}  
      </div>
    </div>

    <div class="form-group">
      <label for="address">Address</label>
      <div class="@if($errors->has('address')) {{'has-error'}} @endif">
        {!!Form::text('address', NULL, array('class' => 'form-control', 'id' => 'address'))!!}  
      </div>
    </div>

    <div class="form-group">
      <label for="postcode">Postcode</label>
      <div class="@if($errors->has('postcode')) {{'has-error'}} @endif">
        {!!Form::text('postcode', NULL, array('class' => 'form-control postal_code', 'id' => 'postcode'))!!}  
      </div>
    </div>

    <div class="form-group">
      <label for="town">Town</label>
      <div class="@if($errors->has('town')) {{'has-error'}} @endif">
        {!!Form::text('town', NULL, array('class' => 'form-control city', 'id' => 'town'))!!}  
      </div>
    </div>

    <div class="form-group">
      <label for="tax_card">Tax Card</label>
      <div class="@if($errors->has('tax_card')) {{'has-error'}} @endif">
        {!!Form::text('tax_card', NULL, array('class' => 'form-control', 'id' => 'tax_card'))!!}  
      </div>
    </div>

    <div class="form-group">
      <label for="comment">Comments</label>
      <div class="@if($errors->has('comment')) {{'has-error'}} @endif">
        {!!Form::textarea('comment', NULL, array('class' => 'form-control', 'id' => 'comment'))!!}  
      </div>
    </div>

    <div class="form-group">
      <label for="permissions">Permissions</label>
      <div class="@if($errors->has('permissions')) {{'has-error'}} @endif">
        <ul class="form-list">
          <li><label>{!! Form::checkbox('permissions[]', 'Customer', NULL) !!} Customer </label></li>
          <li><label>{!! Form::checkbox('permissions[]', 'Invoice', NULL) !!} Invoice </label></li>
          <li><label>{!! Form::checkbox('permissions[]', 'Collections', NULL) !!} Collections </label></li>
          <li><label>{!! Form::checkbox('permissions[]', 'Accounting', 1, array('disabled' => 'disabled')) !!} Accounting </label></li>
          <li><label>{!! Form::checkbox('permissions[]', 'Inventory', 1, array('disabled' => 'disabled')) !!} Inventory </label></li>
          <li><label>{!! Form::checkbox('permissions[]', 'Statistics', NULL) !!} Statistics </label></li>
        </ul>
      </div>
    </div>

    <div>
      @include('tenant.users.emailForm')
    </div>

</div><!-- /.box-body -->


<script type="text/javascript">
$(function () {

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

           





