$(function () {

    var productDatatable = $("#table-product").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "order": [[0, "desc"]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'inventory/product/data',
            "type": "POST"
        },


        "columnDefs": [{
            "orderable": false,
            "targets": 5,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        },
            {
                "targets": 2,
                "render": function (data, type, row) {
                    return '<a href="#" data-toggle="modal" data-url="' + row.show_url + '" data-target="#fb-modal">' +
                    data + '</a>';
                }
            }
        ],
        "columns": [
            {"data": "id"},
            {"data": "number"},
            {"data": "name"},
            {"data": "purchase_cost"},
            {"data": "selling_price"}

        ],

        "fnRowCallback": function (nRow, aData, iDisplayIndex) {

            $(nRow).attr('id', 'product-' + aData.id);
            return nRow;
        }

    });


    $(document).on('submit', '#product-form', function (e) {
        e.preventDefault();
        
        var form = $(this);
        var formAction = form.attr('action');
        var formData = form.serialize();
        var requestType = form.find('.product-submit').val();
        var sp = $('#selling_price').val();
        var cp = $('#purchase_cost').val();
        var vat = $('#vat').val();

        form.find('.product-submit').val('loading...');
        form.find('.product-submit').attr('disabled', 'disabled');

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();
        form.find('.callout').remove();
       
       if(parseInt(sp) > parseInt(cp)){
            $('.modal-body #purchase_cost').parent().addClass('has-error')
            $('.modal-body #purchase_cost').after('<label class="error error-purchase_cost">Selling cost must be greater than purchased cost.<label>');
             form.find('.product-submit').removeAttr('disabled');
            form.find('.product-submit').val('Add');
            
       }else{

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
                        $('.mainContainer .box-solid').before(notify('success', 'Product added Successfully'));
                        tbody.prepend(getTemplate(response.data, false));
                    }
                    else {
                        $('.mainContainer .box-solid').before(notify('success', 'Product updated Successfully'));
                        tbody.find('#product-' + response.data.id).html(getTemplate(response.data, true));
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
                else {

                    if ("errors" in response.data) {

                        $.each(response.data.errors, function (id, error) {
                            $('.modal-body #' + id).parent().addClass('has-error');
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

       }


    })
    return false;
})


$(document).on('click', '.btn-delete-product', function (e) {
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
            url: appUrl + 'inventory/product/' + id + '/delete',
            type: 'GET',
            dataType: 'json'
        })
            .done(function (response) {
                if (response.status === 1) {
                    $('.mainContainer .box-solid').before(notify('success', response.data.message));
                    parentTr.remove();
                } else {
                    $('.mainContainer .box-solid').before(notify('error', response.data.message));
                    parentTr.show('fast');
                }
                setTimeout(function () {
                    $('.callout').remove()
                }, 2500);
            })
            .fail(function () {
                parentTr.show('fast');
                alert('something went wrong');
            })
            .always(function () {
                doing = false;
            });
    }

});


function notify(type, text) {
    return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
}

function showActionbtn(row) {
    return '<div class="box-tools">' +
    '<a href="#" title="Edit" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' + row.edit_url + '" data-target="#fb-modal">' +
    '<i class="fa fa-edit"></i>' +
    '</a>' +
    '<button class="btn btn-box-tool btn-delete-product" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
    '</div>';

}


function getTemplate(data, type) {

    var html = '<td>' + data.id + '</td>' +
        '<td>' + data.number + '</td>' +
        '<td>' + '<a href="#" data-toggle="modal" data-url="' + data.show_url + '" data-target="#fb-modal">' +
        data.name + '</a>' + '</td>' +
        '<td>' + data.purchase_cost + '</td>' +
        '<td>' + data.selling_price + '</td>' +
        '<td>' + data.vat + '</td>' +
        '<td>' + showActionbtn(data) + '</td>';

    if (type == false)
        return '<tr class="product-' + data.id + '">' + html + '</tr>';
    else
        return html;
}