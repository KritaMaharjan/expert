</div>

<div class="footer-container">
    <footer class="container signup-footer" id="footer">
    <p>&copy; copyright 2015 | FastBooks </p>
  </footer>
</div>
    <script src="{!! asset('assets/js/jquery.min.js')!!}"></script>
    <script src="{{ asset('assets/plugins/jquery-ui-1.11.4.custom/jquery-ui.js')}}" type="text/javascript"></script>
<link href="{{ asset('assets/plugins/jquery-ui-1.11.4.custom/jquery-ui.css')}}" rel="stylesheet" type="text/css" /> 
    <!-- <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script> -->
    <script src="{!! asset('assets/js/bootstrap.min.js')!!}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}" type="text/javascript"></script>
    
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{ asset('assets/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
    <script src="{!! asset('assets/plugins/iCheck/icheck.min.js')!!}" type="text/javascript"></script>

    <script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/app.min.js')}}" type="text/javascript"></script>

    


    
    <script type="text/javascript">
      // LINE CHART
        var line = new Morris.Line({
          element: 'line-chart',
          resize: true,
          data: [
            {y: '2011 Q1', item1: 2666, item2: 2666, item3: 15666, item4: 13666},
            {y: '2011 Q2', item1: 2778, item2: 2294, item3: 14666, item4: 12666},
            {y: '2011 Q3', item1: 4912, item2: 1969, item3: 10066, item4: 9666},
            {y: '2011 Q4', item1: 3767, item2: 3597, item3: 13066, item4: 11666},
            {y: '2012 Q1', item1: 6810, item2: 1914, item3: 3566, item4: 12666},
            {y: '2012 Q2', item1: 5670, item2: 4293, item3: 2696, item4: 9666},
            {y: '2012 Q3', item1: 4820, item2: 3795, item3: 1666, item4: 12666},
            {y: '2012 Q4', item1: 15073, item2: 5967, item3: 4666, item4: 11666},
            {y: '2013 Q1', item1: 10687, item2: 4460, item3: 3666, item4: 6666},
            {y: '2013 Q2', item1: 8432, item2: 5713, item3: 2866, item4: 7666}
          ],
          xkey: 'y',
          ykeys: ['item1', 'item2', 'item3', 'item4'],
          labels: ['Customers', 'Billing', 'Collection', 'Statistics'],
          lineColors: ['#fd9d11','#237a7a','#7070a0','#d45127'],
          hideHover: 'auto'
        });
    </script>
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