{{-- Address Details--}}
<div class="box no-border">
    <div class="box-header">
        <h3 class="box-title">Contact Details</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        @foreach($applicant->phone as $phone)
            <div class="form-group">
                <div class='col-md-2 control-label'>{!!Form::label(ucfirst($phone->type).' Number') !!}</div>
                <div class='col-md-6'>
                    <input type="text" value="{{$phone->number}}" class="form-control" name="{{$phone->type}}[{{$app_key}}]" />
                </div>
            </div>
        @endforeach
    </div>
</div>