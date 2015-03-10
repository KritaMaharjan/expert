   @extends('system.layouts.min')

   @section('content')
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="{{url()}}"><b>Fast</b>Books</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        @if(Session::has('message'))
        <div class="callout callout-danger">
          <h4>Invalid Login</h4>
          <p>{{Session::get('message')}}</p>
      </div>
    @endif
        <h3>Forgot your password?</h3>
        <p class="login-box-msg">To reset your password, enter the email address you used to sign in to FastBooks.</p>
        <form action="{{url('system/forgot-password')}}" method="post" name="resetpassword">
                 <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="form-group has-feedback">
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
    @stop

   <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="assets/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>








