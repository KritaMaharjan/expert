<div class="box box-solid">
      <div class="box-header">
          <h3 class="box-title">Edit User</h3>
      </div>
      <div class="">
      {!! Form::model($user, array('route' => 'tenant.user.update', 'method'=>'POST', 'files'=>true, 'id'=>'subuser-update-form')) !!}
        {!!Form::hidden('guid',$user->guid, array('class' => 'form-control', 'id' => 'guid'))!!}  
            @include('tenant.users.userForm')
        <div class="box-footer clearfix">
          {!! Form::button('Save', array('class'=>'btn btn-primary pull-right subuser-submit', 'type'=>'submit')) !!}
        </div>
      {!! Form::close() !!}
    </div>
    </div>
  </div>