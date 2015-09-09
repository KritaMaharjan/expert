<div id="inventory-modal-data" class="hide">
     <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Add New Inventory</h3>
            </div>
           {!!Form::open(['id'=>'inventory-form'])!!}
            @include('tenant.inventory.main.form')

            <div class="box-footer">
                <button type="button" class="btn sm-mg-btn" data-dismiss="modal"><i class="fa fa-times"></i> Abort</button>
                <input type="submit" class="btn btn-primary inventory-submit" value="Add" />
            </div>
           {!!Form::close()!!}
     </div>
</div>

