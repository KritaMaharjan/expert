</div>

<div class="footer-container">
    <footer class="container signup-footer" id="footer">
    <p>&copy; copyright 2015 | FastBooks </p>
  </footer>
</div>
    <script src="{!! asset('assets/js/jquery.min.js')!!}"></script>
    <!-- <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script> -->
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
    <?php FB::loadJS();?>
    <!-- change it later with current domain -->
    <script type="text/javascript">
      var app_url = "<?php echo URL::to('/manish_co/') ?>/";
    </script>
  </body>
</html>