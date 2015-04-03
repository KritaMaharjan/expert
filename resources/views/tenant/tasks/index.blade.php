@extends('tenant.layouts.main')
@section('heading')
Tasks
@stop

@section('breadcrumb')
    @parent
    <li><a data-push="true" href="{{tenant_route('tenant.invoice.index')}}"><i class="fa fa-tasks"></i> Tasks</a></li>
@stop

@section('content')

<div class="row">
        <div class="col-xs-12 mainContainer">
          <div class="box box-solid main-box-solid">

            <!-- TO DO List -->
              <div class="box box-solid">
                <div class="box-header">
                  <i class="ion ion-clipboard"></i>
                  <h3 class="box-title">Upcoming Tasks</h3>
                  <div class="box-tools pull-right">
                    <a class="btn btn-primary" data-toggle="modal" data-url="#task-modal-data" data-target="#fb-modal">
                        <i class="fa fa-plus"></i> Add New Task
                    </a>
                    {{--<a class="btn btn-primary" data-toggle="modal" data-url="#todo-modal-data" data-target="#fb-modal">
                        <i class="fa fa-tasks"></i> To Do List
                    </a>
--}}
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body task-list" id="task-list">
                 @include('tenant.tasks.taskList')
                </div><!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                
                  {{-- <ul class="pagination pagination-sm inline pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                  </ul> --}}
                </div>
              </div><!-- /.box -->

          </div><!-- /.box -->


        {{--Completed List--}}
        <div class="box box-solid">

          <!-- TO DO List -->
            <div class="box box-solid">
              <div class="box-header">
                <i class="ion ion-clipboard"></i>
                <h3 class="box-title">Completed List</h3>
              </div><!-- /.box-header -->
              <div class="box-body" id="completed-list">
              @include('tenant.tasks.completedList')
              </div><!-- /.box-body -->
              <div class="box-footer clearfix no-border">
                {{-- <ul class="pagination pagination-sm inline pull-right">
                  <li><a href="#">&laquo;</a></li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">&raquo;</a></li>
                </ul> --}}  
                
              </div>
            </div><!-- /.box -->

        </div><!-- /.box -->
        </div>
</div>
<div id="task-modal-data" class="hide">
     <div class="box box-solid">
        @include('tenant.tasks.create')
     </div>
 </div>

 <div id="todo-modal-data" class="hide">
     <div class="box box-solid">
        @include('tenant.tasks.todo')
     </div>
 </div>

    {{--Load JS--}}
    {{ FB::registerModal() }}
    {{ FB::js('assets/js/tasks.js') }}

<script type="text/javascript">
  $(function(){
    $(document).on('click', '.text', function (e) {
    //$('.text').click(function(){
      $(this).parent().find('.todos-box').slideToggle('fast');

    })
  });
</script>

<div class="container">
<div class="row">
<div class='col-sm-6'>
<div class="form-group">
<div class='input-group date' id='datetimepicker1'>
<input type='text' class="form-control" />
<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
</span>
</div>
</div>
</div>
</div>
</div>

@stop