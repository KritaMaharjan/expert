<div id="subuser-modal-data" class="hide">
     <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Add New User</h3>
            </div>
            {!! Form::open(array('url' => tenant()->url('users/save'), 'method'=>'POST', 'files'=>true, 'id'=>'subuser-form')) !!}
                @include('tenant.users.userForm')
            <div class="box-footer clearfix">
                {!! Form::button('Save', array('class'=>'btn btn-primary pull-right subuser-submit', 'type'=>'submit')) !!}
            </div>
{!! Form::close() !!}