<div class="box-body">
    <div class="form-group">
        {!! Form::label('number', 'Product Number') !!}
        {!! Form::text('number',null,['class'=>'form-control']) !!}
    </div>


    <div class="form-group">
        {!! Form::label('name', 'Product Name') !!}
        {!! Form::text('name',null,['class'=>'form-control']) !!}
    </div>

    {{--<div class="form-group">
        {!! Form::label('vat', 'Vat(%)') !!}
        {!! Form::text('vat',null,['class'=>'form-control']) !!}
    </div>--}}

    <div class="form-group">
        {!! Form::label('selling_price', 'Selling Price') !!}
        {!! Form::text('selling_price',null,['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('purchase_cost', 'Product Cost') !!}
        {!! Form::text('purchase_cost',null,['class'=>'form-control']) !!}
    </div>

</div>
