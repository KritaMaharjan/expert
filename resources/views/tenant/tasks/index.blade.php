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
                    <a class="btn btn-primary pull-right" data-toggle="modal" data-url="#task-modal-data" data-target="#fb-modal">
                        <i class="fa fa-plus"></i> Add new task
                    </a>

                    <a class="btn btn-primary pull-right" data-toggle="modal" data-url="#todo-modal-data" data-target="#fb-modal">
                        <i class="fa fa-tasks"></i> To Do List
                    </a>

                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul class="todo-list upcoming-tasks">

                    @foreach($tasks['upcoming_tasks'] as $task)
                    <li id = {{$task->id}}>
                      <!-- checkbox -->
                      <input type="checkbox" value="" name="" class="icheck"/>
                      <!-- todo text -->
                      <span class="text">{{ $task->subject }}</span>
                      <!-- Emphasis label -->
                      {!! calculate_todo_time($task->due_date) !!}
                      <!-- General tools such as edit or delete-->
                      <div class="tools">
                        {{--<i class="fa fa-edit"></i>--}}
                        <a href="#" title="Edit" data-original-title="Edit" class="btn btn-box-tool"  data-toggle="modal" data-url="{{ tenant()->url('tasks/' . $task->id . '/edit') }}" data-target="#fb-modal" data-url="" >
                            <i class="fa fa-edit"></i>
                        </a>
                        <i class="fa fa-trash-o btn-delete-task" data-id="{{ $task->id }}"></i>
                      </div>
                      <div class="todos-box pad-lr-29">
                        <div>
                          <label>Added date:</label>
                          <span>{{ format_datetime($task->created_at) }}</span>
                        </div>
                        <div>
                          <label>Due date:</label>
                          <span>{{ format_datetime($task->due_date) }}</span>
                        </div>
                        <p>{{ $task->body }}</p>
                      </div>
                    </li>
                    @endforeach
                  </ul>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                  <ul class="pagination pagination-sm inline pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                  </ul>
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
              <div class="box-body">
              <ul class="todo-list completed-tasks">
                    @if(count($tasks['completed_tasks']) == 0)
                        <p class="no-results">No completed tasks</p>
                    @else

                        @foreach($tasks['completed_tasks'] as $task)
                            <li id = {{$task->id}}>
                              <!-- checkbox -->
                              <input type="checkbox" value="" name="" class="icheck" checked="checked"/>
                              <!-- todo text -->
                              <span class="text">{{ $task->subject }}</span>
                              <!-- Emphasis label -->
                              {!! calculate_todo_time($task->completion_date, true) !!}
                              <!-- General tools such as edit or delete-->
                              <div class="tools">
                                <i class="fa fa-trash-o btn-delete-task" data-id="{{ $task->id }}"></i>
                              </div>
                              <div class="todos-box pad-lr-29">
                                  <div>
                                    <label>Added date:</label>
                                    <span>{{ format_datetime($task->created_at) }}</span>
                                  </div>
                                  <div>
                                    <label>Due date:</label>
                                    <span>{{ format_datetime($task->due_date) }}</span>
                                  </div>
                                  <div>
                                      <label>Completed date:</label>
                                      <span>{{ format_datetime($task->completion_date) }}</span>
                                  </div>
                                  <p>{{ $task->body }}</p>
                              </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
              </div><!-- /.box-body -->
              <div class="box-footer clearfix no-border">
                <ul class="pagination pagination-sm inline pull-right">
                  <li><a href="#">&laquo;</a></li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">&raquo;</a></li>
                </ul>
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