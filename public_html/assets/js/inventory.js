$(function () {

    var inventoryDatatable = $("#table-inventory").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'inventory/data',
            "type": "POST"
        },
        "columnDefs": [{
            "orderable": false,
            "targets": 7,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "id"},
            {"data": "name"},
            {"data": "quantity"},
            {"data": "total_selling_price"},
            {"data": "total_purchase_cost"},
            {"data": "vat"},
            {"data": "purchase_date"}
        ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            
            $(nRow).attr('id','inventory-'+aData.id);
            return nRow;
        },

    });


    $(document).on('click', '.btn-delete-inventory', function (e) {
        e.preventDefault();
        var $this = $(this);
        var parentTr = $this.parent().parent().parent();
        var id = $this.attr('data-id');
        var doing = false;

        if (!confirm('Are you sure, you want delete? This action will delete data permanently and can\'t be undo')) {
            return false;
        }

        if (id != '' && doing == false) {
            doing = true;
            parentTr.hide('slow');

            $.ajax({
                url: appUrl + 'inventory/' + id + '/delete',
                type: 'GET',
                dataType: 'json',
            })
                .done(function (response) {
                    console.log(response);
                    if (response.status === 1) {
                        $('.mainContainer .box-solid').before(notify('success', response.data.message));
                         window.location.href=appUrl+'inventory';
                    } else {
                        $('.mainContainer .box-solid').before(notify('error', response.data.message));
                        parentTr.show();
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                })
                .fail(function () {
                    alert('something went wrong');
                    parentTr.show();
                })
                .always(function () {
                    doing = false;
                });
        }

    });

    $(document).on('submit', '#inventory-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = form.attr('action');
        var formData = form.serialize();
        var requestType = form.find('.inventory-submit').val();

        form.find('.inventory-submit').val('loading...');
        form.find('.inventory-submit').attr('disabled', 'disabled');

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
                    $('#fb-modal').modal('hide');
                    var tbody = $('.box-body table tbody');
                    if (requestType == 'Add') {
                        console.log(response);
                        $('.mainContainer .box-solid').before(notify('success', 'Product added Successfully'));
                        tbody.prepend(getTemplate(response, false));
                    }
                    else {
                        $('.mainContainer .box-solid').before(notify('success', 'Product updated Successfully'));
                        tbody.find('#inventory-' + response.data.id).html(getTemplate(response, true));
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
                else {
                   /* if ("errors" in response.data) {*/
                        $.each(response.errors, function (id, error) {
                            $('.modal-body #' + id).parent().addClass('has-error')
                            $('.modal-body #' + id).after('<label class="error error-' + id + '">' + error[0] + '<label>');
                        })
                   /* }

                    if ("error" in response.data) {
                        form.prepend(notify('danger', response.data.error));
                    }*/

                }
            })
            .fail(function () {
                alert('something went wrong');
            })
            .always(function () {
                form.find('.inventory-submit').removeAttr('disabled');
                form.find('.inventory-submit').val(requestType);
            });
    })
})


function notify(type, text) {
    return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
}

function showActionbtn(row) {
    return '<div class="box-tools">' +
    '<a href="#" title="Edit" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' + appUrl + 'inventory/' + row.id + '/edit" data-target="#fb-modal">' +
    '<i class="fa fa-edit"></i>' +
    '</a>' +
    '<button class="btn btn-box-tool btn-delete-inventory" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
    '</div>';

}


function getTemplate(response, type) {

   console.log(response);
    var html = '<td>' + response.data.id + '</td>' +
        '<td>' +  response.data.name + '</td>' +
        '<td>' + response.data.quantity + '</td>' +
        '<td>' + response.data.purchase_cost + '</td>' +
        '<td>' + response.data.selling_price + '</td>' +
        '<td>' + response.data.vat + '</td>'+
        '<td>' + response.data.purchase_date + '</td>'+
        '<td><div class="box-tools pull-right">' +
        '<a href="#" title="Edit" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' + response.data.edit_url + '" data-target="#fb-modal">' +
        '<i class="fa fa-edit"></i>' +
        '</a>' +
        '<button class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
        '</div>' +
        '</td>';

    if (type == false)
        return '<tr class="inventory-' + response.data.id + '">' + html + '</tr>';
    else
        return html;
}