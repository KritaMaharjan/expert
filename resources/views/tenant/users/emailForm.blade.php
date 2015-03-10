<fieldset class="wrapper-box">
<legend>Email settings</legend>
<div class="form-group">
  <label for="incoming_server">SMTP server (Incoming)</label>
  <div class="@if($errors->has('incoming_server')) {{'has-error'}} @endif">
    {!!Form::text('incoming_server', NULL, array('class' => 'form-control', 'id' => 'incoming_server'))!!}  
  </div>
</div>

<div class="form-group">
  <label for="outgoing_server">SMTP server (Outgoing) </label>
  <div class="@if($errors->has('outgoing_server')) {{'has-error'}} @endif">
    {!!Form::text('outgoing_server', NULL, array('class' => 'form-control', 'id' => 'outgoing_server'))!!}  
  </div>
</div>

<div class="form-group">
  <label for="email_username">Username</label>
  <div class="@if($errors->has('email_username')) {{'has-error'}} @endif">
    {!!Form::text('email_username', NULL, array('class' => 'form-control', 'id' => 'email_username'))!!}  
  </div>
</div>

<div class="form-group">
  <label for="email_password">Password</label>
  <div class="@if($errors->has('email_password')) {{'has-error'}} @endif">
    {!!Form::text('email_password', NULL, array('class' => 'form-control', 'id' => 'email_password'))!!}  
  </div>
</div>
</fieldset>

