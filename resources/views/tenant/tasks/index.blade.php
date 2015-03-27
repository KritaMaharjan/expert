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
          <div class="box box-solid">

            <!-- TO DO List -->
              <div class="box box-solid">
                <div class="box-header">
                  <i class="ion ion-clipboard"></i>
                  <h3 class="box-title">Upcoming Tasks</h3>
                  <div class="box-tools pull-right">
                    <a class="btn btn-primary pull-right" data-toggle="modal" data-url="#task-modal-data" data-target="#fb-modal">
                        <i class="fa fa-plus"></i> Add new task
                    </a>

                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul class="todo-list">

                    @foreach($tasks['upcoming_tasks'] as $task)
                    <li>
                      <!-- checkbox -->
                      <input type="checkbox" value="" name=""/>
                      <!-- todo text -->
                      <span class="text">{{ $task->subject }}</span>
                      <!-- Emphasis label -->
                      {!! calculate_todo_time($task->due_date) !!}
                      <!-- General tools such as edit or delete-->
                      <div class="tools">
                        <i class="fa fa-edit"></i>
                        <i class="fa fa-trash-o"></i>
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
                @if(count($tasks['completed_tasks']) == 0)
                    <p>No completed tasks</p>
                @else
                    <ul class="todo-list">
                        @foreach($tasks['completed_tasks'] as $task)
                            <li>
                              <!-- checkbox -->
                              <input type="checkbox" value="" name=""/>
                              <!-- todo text -->
                              <span class="text">{{ $task->subject }}</span>
                              <!-- Emphasis label -->
                              {!! calculate_todo_time($task->completion_date, true) !!}
                              <!-- General tools such as edit or delete-->
                              <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                              </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
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
    {{--Load JS--}}
    {{ FB::registerModal() }}
    {{ FB::js('assets/js/tasks.js') }}

@stop