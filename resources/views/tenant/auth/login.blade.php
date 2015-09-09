   @extends('system.layouts.min')

   @section('content')
    <div class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="{{site_url()}}"><b>Fast</b>Books</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in</p>
    @if(Session::has('message'))
        <div class="callout callout-danger">
          <h4>Invalid Login</h4>
          <p>{{Session::get('message')}}</p>
      </div>
    @endif
    @if(Session::has('message_success'))
        <div class="callout callout-success">
            <p>{{Session::pull('message_success')}}</p>
        </div>
    @endif


    @if (Session::has('flash_notification.message'))
        @if (Session::has('flash_notification.overlay'))
            @include('flash::modal', ['modalClass' => 'flash-modal', 'title' => Session::get('flash_notification.title'), 'body' => Session::get('flash_notification.message')])
        @else
            <div class="alert alert-{{ Session::get('flash_notification.level') }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                {{ Session::get('flash_notification.message') }}
            </div>
        @endif
    @endif



        <form action=" " method="post">

       <input type="hidden" name="_token" value="{{csrf_token()}}">
          <div class="form-group has-feedback @if($errors->has('email')) {{'has-error'}} @endif">
            <input type="text" class="form-control" name="email" placeholder="Email" value="{{old('email')}}"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
           @if($errors->has('email'))
           {!! $errors->first('email', '<label class="control-label" for="inputError">:message</label>') !!}
           @endif

          </div>
          <div class="form-group has-feedback @if($errors->has('password')) {{'has-error'}} @endif">
            <input type="password" name="password" class="form-control" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              @if($errors->has('password'))
                     {!! $errors->first('password', '<label class="control-label" for="inputError">:message</label>') !!}
              @endif
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>



        <a href="{{tenant_route('tenant.forgetPassword')}}"><small>I forgot my password</small></a><br>
        <a href="{{ site_url() }}" class="text-center"><small>Register a new account</small></a>

      </div><!-- /.login-box-body -->
      <div class="login-box-footer">
        <p><small>&copy; copyright 2015 | FastBooks </small></p>
      </div>
    </div><!-- /.login-box -->

    </div>

    @stop