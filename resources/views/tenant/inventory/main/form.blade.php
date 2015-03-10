<div class="box-body">
    <div class="form-group">
        {!! Form::label('product_id', 'Product') !!}
        {!! Form::select('product_id',$product_list, null,['class'=>'form-control select-single']) !!}
    </div>


    <div class="form-group">
        {!! Form::label('quantity', 'Quantity') !!}
        {!! Form::text('quantity',null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('purchase_date', 'Purchase Date') !!}
        {!! Form::text('purchase_date',null,['class'=>'form-control date-picker']) !!}
    </div>
</div>