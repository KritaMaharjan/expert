   <script src="{!! asset('assets/js/jquery.min.js')!!}"></script>
    <script src="{!! asset('assets/js/jquery-1.9.1.min')!!}"></script>
    <script src="{!! asset('assets/js/bootstrap.min.js')!!}" type="text/javascript"></script>
   
    <script src="{!! asset('assets/plugins/iCheck/icheck.min.js')!!}" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });

        
      });
    </script>
  </body>
</html>