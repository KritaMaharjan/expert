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