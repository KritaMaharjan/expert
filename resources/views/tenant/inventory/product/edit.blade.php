<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">Edit Product</h3>
    </div>
       {!!Form::model($product,['id'=>'product-form'])!!}
        @include('tenant.inventory.product.form')


        <div class="box-footer">
            <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
            <input type="submit" class="btn btn-primary product-submit" value="Update" />
        </div>
       {!!Form::close()!!}
</div>
