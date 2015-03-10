<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">Edit Inventory</h3>
    </div>
       {!!Form::model($inventory,['id'=>'inventory-form'])!!}
        @include('tenant.inventory.main.form')
        <div class="box-body">
            <div class="form-group">
            {!! Form::label('vat', 'Vat(%)') !!}
            {!! Form::text('vat',null,['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
            {!! Form::label('selling_price', 'Selling Price') !!}
            {!! Form::text('selling_price',null,['class'=>'form-control']) !!}
            </div>

            <div class="form-group">
            {!! Form::label('purchase_cost', 'Product Cost') !!}
            {!! Form::text('purchase_cost',null,['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="box-footer">
            <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
            <input type="submit" class="btn btn-primary product-submit" value="Update" />
        </div>
       {!!Form::close()!!}
</div>


