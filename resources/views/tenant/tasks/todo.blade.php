<div class="box-header">
    <h3 class="box-title">To Do List</h3>
</div>
<div class="box-body">
    <ul class="todo-list upcoming-tasks">
        @foreach($tasks['todo_tasks'] as $task)
        <li id = {{$task->id}} class="clearfix">
          <!-- to do text -->
          <span class="text">{{ $task->subject }}</span>
          {!! calculate_todo_time($task->due_date) !!}
          <div class="todos-box pad-lr-29">
            <div class="clearfix">
              <label>Added date:</label>
              <span>{{ format_datetime($task->created_at) }}</span>
            </div>
            <div class="clearfix">
              <label>Due date:</label>
              <span>{{ format_datetime($task->due_date) }}</span>
            </div>
            <p>{{ $task->body }}</p>
          </div>
        </li>
        @endforeach
      </ul>
</div>
<div class="box-footer clearfix">
    <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
    <input type="submit" class="btn btn-primary task-submit" value="Add" />
</div>