@extends('tenant.layouts.main')

@section('heading')
Template Settings
@stop

@section('breadcrumb')
    @parent
    <li><i class="fa fa-cog"></i> Setting</li>
    <li><i class="fa fa-cog"></i> Template</li>
@stop

@section('content')

    <div class="box box-solid">
        <div class="box-body">
         
        	<form role="form" method="post" action="{{route('tenant.setting.update')}}" >
                <input type="hidden" name="_token" value="{{csrf_token()}}">

                <input type="hidden" name="group"  class="form-control" value="template">
            <div class="form-group">
                <label>Setting template </label><br>
                 <label>Subject : </label>
                <input type="name" name="setting_subject" class="form-control" value="{{ $setting->setting_subject or old('name') }}"><br>
                 <label>Body : </label>
                    <textarea id="editor1" rows="3" name="setting_template" class="form-control textarea">{{ $setting->setting_template or old('setting_template') }}</textarea>

            </div>
            <div class="form-group">
                <label>Account confirmation email</label><br>
                <label>Subject : </label>
                <input type="name" name="confirmation_email_subject" class="form-control" value="{{ $setting->confirmation_email_subject or old('name') }}"><br>
                 <label>Body : </label>
                    <textarea id="editor2" rows="3" name="confirmation_email" class="form-control">{{ $setting->confirmation_email or old('confirmation_email') }}</textarea>
            </div>
            <div class="form-group">
                <label>Tenant domain setup</label><br>
                <label>Subject : </label>
                <input type="name" name="domain_setup_subject" class="form-control" value="{{ $setting->domain_setup_subject or old('name') }}"><br>
                 <label>Body : </label>
                    <textarea id="editor3" rows="3" name="domain_setup" class="form-control">{{ $setting->domain_setup or old('domain_setup') }}</textarea>
            </div>
            <div class="form-group">
                <label>Forgot password</label><br>
                 <label>Subject : </label>
                <input type="name" name="forgot_password_subject" class="form-control" value="{{ $setting->forgot_password_subject or old('name') }}"><br>
                 <label>Body : </label>
                    <textarea id="editor4" rows="3" name="forgot_password" class="form-control">{{ $setting->forgot_password or old('forgot_password') }}</textarea>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
        </div>
    <div>
          <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/ckeditor/styles.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
        CKEDITOR.replace('editor2');
        CKEDITOR.replace('editor3');
        CKEDITOR.replace('editor4');
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
      });
    </script>
@stop