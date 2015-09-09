@extends('system.layouts.min')

@section('content')

<div class="login-box">
      <div class="login-logo">
        <a href="index.html"><b>Fast</b>Books</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
       
      	<h3>Forgot your password?</h3>
        <p class="login-box-msg">To reset your password, enter the email address you used to sign in to FastBooks.</p>
          @if(Session::has('message'))
        <div class="callout callout-danger">
          <h4>Invalid Login</h4>
          <p>{{Session::get('message')}}</p>
      </div>
    @endif
        <form action="" method="post" name="reset">
          <div class="form-group has-feedback">
             <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="email" class="form-control" name="email" placeholder="Email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          
          <div class="row">            
            <div class="col-xs-4 pull-right">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Send</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
      <div class="login-box-footer">
        <p><small>&copy; copyright 2015 | FastBooks </small></p>
      </div>
    </div><!-- /.login-box -->

   <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="assets/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
   
 @stop