<div class="box-header">
    <h3 class="box-title">Add New Task</h3>
</div>
{!! Form::open(array('method'=>'POST', 'id'=>'task-form', 'files'=>'true')) !!}
    @include('tenant.tasks.form')
    <div class="box-footer clearfix">
        <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
        <input type="submit" class="btn btn-primary task-submit" value="Add" />
    </div>
{!! Form::close() !!}
