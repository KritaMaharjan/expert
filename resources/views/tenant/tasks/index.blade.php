@extends('tenant.layouts.main')
@section('heading')
Tasks
@stop

@section('breadcrumb')
    @parent
    <li>Tasks</li>
@stop

@section('content')

<div class="row">
        <div class="col-xs-12 mainContainer">
          <div class="box box-solid main-box-solid">

            <!-- TO DO List -->
              <div class="box box-solid">
                <div class="box-header">
                  <i class="fa fa-clipboard"></i>
                  <h3 class="box-title">Upcoming Tasks</h3>
                  <div class="box-tools pull-right">
                    <a href="#" title="New Task" data-original-title="New Task" class="btn btn-primary" data-toggle="modal" data-type="personal" data-target="#task-modal-data">
                        <i class="fa fa-pencil"></i> New Task
                    </a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body task-list" id="task-list">
                 @include('tenant.tasks.taskList')
                </div><!-- /.box-body -->
                <div class="box-footer clearfix no-border">

                </div>
              </div><!-- /.box -->

          </div><!-- /.box -->


        {{--Completed List--}}
        <div class="box box-solid">

          <!-- TO DO List -->
            <div class="box box-solid">
              <div class="box-header">
                <i class="fa fa-clipboard"></i>
                <h3 class="box-title">Completed Tasks</h3>
              </div><!-- /.box-header -->
              <div class="box-body" id="completed-list">
              @include('tenant.tasks.completedList')
              </div><!-- /.box-body -->
              <div class="box-footer clearfix no-border">
                
              </div>
            </div><!-- /.box -->

        </div><!-- /.box -->
        </div>
</div>
<div class="modal modal-right fade" id="task-modal-data" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            @include('tenant.tasks.create')
        </div>
    </div>
 </div>

{{--Load JS--}}
{{ FB::registerModal() }}
{{ FB::js('assets/js/tasks.js') }}
{{ FB::js('assets/plugins/timepicker/bootstrap-timepicker.min.js') }}

<script type="text/javascript">
  $(function(){
    $(document).on('click', '.text', function (e) {
      var $this = $(this).parent().find('.todos-box');
      $(".todos-box").not($this).hide();
      $(this).parent().find('.todos-box').slideToggle('fast');
    });
  });
</script>

@stop