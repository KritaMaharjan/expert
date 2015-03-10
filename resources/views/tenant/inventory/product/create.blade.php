<div id="product-modal-data" class="hide">
     <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Add New Product</h3>
            </div>
           {!!Form::open(['id'=>'product-form'])!!}
            @include('tenant.inventory.product.form')
            <div class="box-footer">
                <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
                <input type="submit" class="btn btn-primary product-submit" value="Add" />
            </div>
           {!!Form::close()!!}
     </div>
</div>