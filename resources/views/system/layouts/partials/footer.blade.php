    </div>
    <footer class="main-footer">
          <strong>Copyright &copy; {{date('Y')}} <a href="{{url()}}" title="Expert Financial Solutions">Expert Financial Solutions</a>.</strong> All rights reserved.
    </footer>
    </div>
    
    <script src="{{ asset('assets/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/moment.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/common.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/select2.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/app.min.js')}}" type="text/javascript"></script>

    {!! EX::loadJS() !!}
    {!! EX::loadModal()!!}
  </body>
</html>