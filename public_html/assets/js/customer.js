$(function () {

    $('.business_div').hide();
    var modal = $('.modal-body');

    $(document).on('click', '#business', function () {

        if (modal.find('#business').is(':checked')) {
            modal.find('#type').val('2');
            modal.find('.dob_div').hide();
            modal.find('.business_div').show();
        } else {
            modal.find('#type').val('1');
            modal.find('.dob_div').show();
            modal.find('.business_div').hide();
        }

    });


    var customerDatatable = $("#table-customer").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "order": [[3, "desc"]],

        //custom processing message
        "oLanguage": {
            "sProcessing": "<i class = 'fa fa-spinner'></i>  Processing..."
        },

        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'customer/data',
            "type": "POST"
        },
        "columnDefs": [{
            "orderable": false,
            "targets": 4,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "id"},
            {"data": "name"},
            {"data": "email"},
            {"data": "created_at"}
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {

            $(nRow).attr('id', 'customer-' + aData.id);
            return nRow;
        }

    });

    var InvoiceDatatable = $("#table-invoices").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',

        //custom processing message
        "oLanguage": {
            "sProcessing": "<i class = 'fa fa-spinner'></i>  Processing..."
        },

        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'customer/invoices/data',
            "type": "POST"
        },
        "columnDefs": [{
            "orderable": false,

            "render": function (data, type, row) {
                // return showActionbtn(row);
            }
        }],

        "columns": [
            {"data": "id"},
            {"data": "total"},
            {"data": "due_date"},
            {"data": "status"}
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {


        }

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
                url: appUrl + 'customer/' + id + '/delete',
                type: 'GET',
                dataType: 'json'
            })
                .done(function (response) {
                    if (response.status == '0') {
                        $.each(response.errors, function (i, v) {
                            $this.closest('form').find('input[name=' + i + ']').after('<label class="error ">' + v + '</label>');
                        });
                    }

                    if (response.status == '1') {
                        window.location.href = appUrl + 'customer';
                    } //success
                    response.success
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


    $(document).on('click', '#search-email', function (e) {
        e.preventDefault();

        var search_option = $('#search_option').val();
        var user_id = $('#user_id').val();

        var doing = false;

        if (doing == false) {
            doing = true;
            $('#email-list').load(appUrl + 'desk/email/search_emails/?user_id=' + user_id + '&search_option=' + search_option);

        }

    });


    /*$(document).on('click', '#customer-submit', function (e) {
        e.preventDefault();
        $('.erroring').remove();
        var form = $('#customer-form');
        var formAction = appUrl + 'customer';
        //var formData = form.serialize();


        var requestType = form.find('.customer-submit').val();

        form.find('.customer-submit').val('loading...');
        form.find('.customer-submit').attr('disabled', true);

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();
        form.find('.callout').remove();


        $.ajax({
            url: formAction,
            type: 'POST',
            dataType: 'json',
            data: formData,

            //required for ajax file upload
            processData: false,
            contentType: false
        })
            .done(function (response) {
                if (response.success == true || response.status == 1) {
                    $('.error').remove();

                    $('#fb-modal').modal('hide');
                    var tbody = $('.box-body table tbody');
                    if (requestType == 'Add') {

                        window.location.replace(response.redirect_url);
                    }
                    else {

                        $('.mainContainer .box-solid').before(notify('success', 'Customer updated Successfully'));
                        tbody.find('#customer-' + response.data.id).html(getTemplate(response, true));

                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
                else {
                    if (response.status == 'fail') {
                        $('.error').remove();
                        $.each(response.errors, function (i, v) {
                            // form.closest('form').find('input[name='+i+']').after('<label class="error ">'+v+'</label>');
                            $('.modal-body #' + i).parent().addClass('has-error');
                            $('.modal-body #' + i).after('<label class="error erroring error-' + i + '">' + v + '<label>');
                        });
                    }

                    // if ("error" in response.data) {
                    //     form.prepend(notify('danger', response.data.error));
                    // }

                }
            })
            .fail(function () {
                alert('something went wrong');
            })
            .always(function () {
                form.find('.customer-submit').removeAttr('disabled');
                form.find('.customer-submit').val(requestType);
            });
    });*/

    $(document).on('submit', '#customer-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = form.attr('action');
        //var formData = form.serialize();

        var formData = new FormData(form[0]);
//        formData.append('photo', $('#customer-form input[type=file]')[0].files[0]);

        var requestType = form.find('.customer-submit').val();

        form.find('.customer-submit').val('loading...');
        form.find('.customer-submit').attr('disabled', true);

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();
        form.find('.callout').remove();


        $.ajax({
            url: formAction,
            type: 'POST',
            dataType: 'json',
            data: formData,

            //required for ajax file upload
            processData: false,
            contentType: false
        })
            .done(function (response) {
                if (response.success == true || response.status == 1) {

                    $('#fb-modal').modal('hide');
                    var tbody = $('.box-body table tbody');
                    if (requestType == 'Add') {

                        window.location.replace(response.redirect_url);
                    }
                    else {

                        $('.mainContainer .box-solid').before(notify('success', 'Customer updated Successfully'));
                        tbody.find('#customer-' + response.data.id).html(getTemplate(response, true));

                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
                else {
                    if (response.status == 'fail') {
                        $.each(response.errors, function (i, v) {
                            // form.closest('form').find('input[name='+i+']').after('<label class="error ">'+v+'</label>');
                            $('.modal-body #' + i).parent().addClass('has-error')
                            $('.modal-body #' + i).after('<label class="error error-' + i + '">' + v + '<label>');
                        });
                    }

                    // if ("error" in response.data) {
                    //     form.prepend(notify('danger', response.data.error));
                    // }

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

});



function notify(type, text) {
    return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
}

function showActionbtn(row) {
    return '<div class="box-tools">' +
    '<a href="#" title="Edit" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' + appUrl + 'customer/' + row.id + '/edit' + '" data-target="#fb-modal">' +
    '<i class="fa fa-edit"></i>' +
    '</a>' +
    '<button class="btn btn-box-tool btn-delete-customer" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
    '</div>';

}


function getTemplate(response, type) {


    var html = '<td>' + response.data.id + '</td>' +
        '<td>' +
        '<a href="#" data-toggle="modal" data-url="' + response.show_url + '" data-target="#fb-modal">' +
        response.data.name +
        '</a>' +
        '</td>' +
        '<td>' + response.data.email + '</td>' +
        '<td>' + response.data.created_at + '</td>' +

        '<td><div class="box-tools" style="float:left;">' +
        '<a href="#" title="Edit" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' + response.edit_url + '" data-target="#fb-modal">' +
        '<i class="fa fa-edit"></i>' +
        '</a>' +
        '<button class="btn btn-box-tool btn-delete-customer" data-toggle="tooltip" data-id="' + response.data.id + '" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
        '</div>' +
        '</td>';

    if (type == false)
        return '<tr class="customer-' + response.data.id + '">' + html + '</tr>';
    else
        return html;
}

