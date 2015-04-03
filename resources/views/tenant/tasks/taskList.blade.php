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

                    @if($tasks['upcoming_tasks']->total() > 1)

<p class="align-right">
<?php
$items = count($tasks['upcoming_tasks']->items());
$to = ($tasks['upcoming_tasks']->currentPage()-1) * $tasks['upcoming_tasks']->perPage() + $items;
if($items >= $tasks['upcoming_tasks']->perPage())
$from =  $to - $tasks['upcoming_tasks']->perPage()+1;
else
$from =  $to - $tasks['upcoming_tasks']->perPage()+1+($tasks['upcoming_tasks']->perPage()-$items);
?>
<span class="color-grey">{{$from}}-{{$to}} of {{$tasks['upcoming_tasks']->total()}}</span>
    @if($from !=1)
      <a href="#{{$tasks['upcoming_tasks']->currentPage()-1}}" data class="mg-lr-5 mail-previous color-grey"><i class="fa  fa-chevron-left"></i></a>
    @endif
    @if($to != $tasks['upcoming_tasks']->total())
      <a href="#{{$tasks['upcoming_tasks']->currentPage()+1}}"  class="color-grey mail-next"><i class="fa  fa-chevron-right"></i></a>
    @endif
</p>
@endif


<script src="{{ asset('assets/plugins/iCheck/icheck.min.js')}}" type="text/javascript"></script>
<script>
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
</script>

