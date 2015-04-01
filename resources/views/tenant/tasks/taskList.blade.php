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