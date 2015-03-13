@extends('tenant.layouts.main')

@section('heading')
Inventory
@stop

@section('breadcrumb')
    @parent
    <li><a data-push="true" href="{{tenant_route('tenant.inventory.index')}}"><i class="fa fa-cog"></i> Inventory</a></li>
    <li><i class="fa fa-cog"></i> Inventory</li>
@stop

@section('content')
<div class="row">
        <div class="col-xs-12 mainContainer">
          <div class="box box-solid">
            <p class="align-right btn-inside">
                 <a class="btn btn-primary" data-toggle="modal" data-url="#inventory-modal-data" data-target="#fb-modal">
                       <i class="fa fa-plus"></i> Add new inventory
                 </a>
             </p>
            <div class="box-body table-responsive">
              <table id="table-inventory" class="table table-hover">
                <thead>
                    <tr>
                      <th>Inventory ID</th>
                      <th>Product name</th>
                      <th>Quantity</th>
                      <th>Total Purchase cost</th>
                      <th>Total Sales price</th>
                      <th>Vat</th>
                      <th>Purchase Date</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
</div>
   @include('tenant.inventory.main.create')
   @include('tenant.inventory.product.create')
    <script>
    $(function(){
      var inventory;
        $(document).on('click','#product-add', function(){
            $(".select-single").select2('destroy');
           inventory = $('#fb-modal').find('.modal-body').html();
           $('#fb-modal').find('.modal-body').html($('#product-modal-data').html());
        });

         $(document).on('submit', '#product-form', function (e) {
                       e.preventDefault();
                       var form = $(this);
                       var formAction = form.attr('action');
                       var formData = form.serialize();
                       var requestType = form.find('.product-submit').val();

                       form.find('.product-submit').val('loading...');
                       form.find('.product-submit').attr('disabled', 'disabled');

                       form.find('.has-error').removeClass('has-error');
                       form.find('label.error').remove();
                       form.find('.callout').remove();

                       $.ajax({
                           url: formAction,
                           type: 'POST',
                           dataType: 'json',
                           data: formData
                       })
                           .done(function (response) {
                               if (response.status === 1) {
                                     $('#fb-modal').find('.modal-body').html($('#inventory-modal-data').html());

                                  $('#fb-modal').find('#product_id').prepend('<option value="'+response.data.id+'">'+response.data.name+'</option>');
                                    var select = $(".select-single").select2({
                                    theme: "classic"
                                    });
                                    select.val(response.data.id).trigger("change");
                                    $(".date-picker").datepicker({'format': 'yyyy-mm-dd'});
                               }
                               else
                               {
                                    if ("errors" in response.data) {

                                   $.each(response.data.errors, function (id, error) {
                                       $('.modal-body #' + id).parent().addClass('has-error')
                                       $('.modal-body #' + id).after('<label class="error error-' + id + '">' + error[0] + '<label>');
                                   })
                               }

                               if ("error" in response.data) {
                                   form.prepend(notify('danger', response.data.error));
                               }
                               }
                       })
                           .fail(function () {
                               alert('something went wrong');
                           })
                           .always(function () {
                               form.find('.product-submit').removeAttr('disabled');
                               form.find('.product-submit').val(requestType);

                           });
                   });
    });
</script>

    {{--Load JS--}}
    {{FB::registerModal()}}
    {{FB::js('assets/js/inventory.js')}}
@stop