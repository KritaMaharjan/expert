<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">Edit Inventory</h3>
    </div>
       {!!Form::model($inventory,['id'=>'inventory-form'])!!}
        @include('tenant.inventory.main.form')
        <div class="box-body edit-mode">
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

<script>
$(".select-single").on("change", function(e){

    var product =  $(this).val();

    $.ajax({
        url: appUrl + 'inventory/product/'+product,
        type: 'GET',
        dataType: 'json'
    })
    .done(function(response) {
       $('.edit-mode').find('#vat').val(response.data.vat)
       $('.edit-mode').find('#selling_price').val(response.data.selling_price)
       $('.edit-mode').find('#purchase_cost').val(response.data.purchase_cost)
    })
    .fail(function() {
        console.log("error");
    })
  });


</script>


