</div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-ui-1.11.4.custom/jquery-ui.js')}}" type="text/javascript"></script>
    <link href="{{ asset('assets/plugins/jquery-ui-1.11.4.custom/jquery-ui.css')}}" rel="stylesheet" type="text/css" />
    <!-- <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script> -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/app.min.js')}}" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
    <?php //FB::loadJS();?>
  </body>
</html>