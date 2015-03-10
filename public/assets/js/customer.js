$(function () {

    var customerDatatable = $("#table-customer").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + '/customer/data',
            "type": "POST"
        },
        "columnDefs": [{
            "orderable": false,
            "targets": 3,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "id"},
            {"data": "name"},
            {"data": "created_at"}
        ]

    });


    $(document).on('click', '.btn-delete-customer', function (e) {
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
                url: appUrl + '/customer/' + id + '/delete',
                type: 'GET',
                dataType: 'json',
            })
                .done(function (response) {
                    if (response.status === 1) {
                        $('.mainContainer .box-solid').before(notify('success', response.data.message));
                        parentTr.remove();
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

    $(document).on('submit', '#customer-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = form.attr('action');
        var formData = form.serialize();
        var requestType = form.find('.customer-submit').val();

        form.find('.customer-submit').val('loading...');
        form.find('.customer-submit').attr('disabled', 'disabled');

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
                        $('.mainContainer .box-solid').before(notify('success', 'Product added Successfully'));
                        tbody.prepend(getTemplate(response, false));
                    }
                    else {
                        $('.mainContainer .box-solid').before(notify('success', 'Product updated Successfully'));
                        tbody.find('tr.customer-' + response.data.id).html(getTemplate(response, true));
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
                else {
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
                form.find('.customer-submit').removeAttr('disabled');
                form.find('.customer-submit').val(requestType);
            });
    })
})


function notify(type, text) {
    return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
}

function showActionbtn(row) {
    return '<div class="box-tools">' +
    '<a href="#" title="Edit" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' + appUrl + '/customer/' + row.id + '/edit" data-target="#fb-modal">' +
    '<i class="fa fa-edit"></i>' +
    '</a>' +
    '<button class="btn btn-box-tool btn-delete-customer" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
    '</div>';

}


function getTemplate(response, type) {


    var html = '<td>' + response.data.id + '</td>' +
        '<td>' + response.data.number + '</td>' +
        '<td>' +
        '<a href="#" data-toggle="modal" data-url="' + response.data.show_url + '" data-target="#fb-modal">' +
        response.data.name +
        '</a>' +
        '</td>' +
        '<td>' + response.data.quantity + '</td>' +
        '<td>' + response.data.purchase_cost + '</td>' +
        '<td>' + response.data.selling_price + '</td>' +
        '<td><div class="box-tools pull-right">' +
        '<a href="#" title="Edit" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' + response.data.edit_url + '" data-target="#fb-modal">' +
        '<i class="fa fa-edit"></i>' +
        '</a>' +
        '<button class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
        '</div>' +
        '</td>';

    if (type == false)
        return '<tr class="customer-' + response.data.id + '">' + html + '</tr>';
    else
        return html;
}