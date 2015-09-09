<div class="box-header">
    <h3 class="box-title">Edit Task</h3>
</div>
{!! Form::model($task, array('method'=>'POST', 'id'=>'task-form', 'files'=>'true')) !!}
    <?php $due_date = date('Y-m-d', strtotime($task->due_date)) ?>
    <?php $due_time = date('H:i:s', strtotime($task->due_date)) ?>
    @include('tenant.tasks.form')
    <div class="box-footer clearfix">
        <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
        <input type="submit" class="btn btn-primary task-submit" value="Update" />
    </div>
{!! Form::close() !!}
