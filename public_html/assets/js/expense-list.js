$(function () {

    var expenseDatatable = $("#table-expense").DataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        //"order": [[0, "desc"]],

        //custom processing message
        "oLanguage": {
            "sProcessing": "<i class = 'fa fa-spinner'></i>  Processing..."
        },

        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'accounting/data',
            "type": "POST"
        },
        "columnDefs": [{
            "orderable": false,
            "targets": 5,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "invoice_number"},
            {"data": "remaining"},
            {"data": "billing_date"},
            {"data": "payment_due_date"},
            {"data": "type"}
        ]

    });


    function showActionbtn(row) {
        return '<div class="box-tools"> ' +
        '<a href="#" title="View Payments" data-original-title="View" class="btn btn-box-tool" data-toggle="modal" data-url="' + appUrl + 'accounting/expense/'+ row.id + '" data-target="#fb-modal">' +
        '<i class="fa fa-eye"></i>' +
        '</a>' +
        '<button class="btn btn-box-tool btn-delete-expense" data-toggle="tooltip" link="'+appUrl+'delete/expense/'+row.id+'" data-id="' + row.id + '" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
        '</div>';
    }

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><p>' + text + '</p></div>';
    }

    $(document).on('submit', '#payment-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = form.attr('action');
        var formData = form.serialize();

        $('.modal-body .error').remove();
        form.find('.payment-submit').html('Loading...');
        form.find('.payment-submit').attr('disabled', 'disabled');

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();
        $('.callout').remove();

        $.ajax({
            url: formAction,
            type: 'POST',
            dataType: 'json',
            data: formData
        })
            .done(function (response) {
                if(response.status == 0)
                {
                    $.each(response.data.errors, function( index, value ) {
                        var errorDiv = '.modal-body #'+index;
                        $(errorDiv).closest( ".form-group" ).addClass('has-error');
                        $('.modal-body #'+index).after('<label class="error error-'+index+'">'+value+'<label>');
                    });
                }

                else {
                    $('.mainContainer .box-solid').before(notify('success', 'Payment added Successfully!'));
                    //change the remaining amount
                    $('#row-'+response.data.result.expense_id).find('td:nth-child(2)').html(response.data.result.remaining);
                    $('.modal').modal('hide');
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                } //success
            })
            .fail(function () {
                alert('Something went wrong! Please try again later!');
            })
            .always(function () {
                form.find('.payment-submit').removeAttr('disabled');
                form.find('.payment-submit').html('Register expense');

            });
    });

    //delete the expense
    $(document).on('click', '.btn-delete-expense', function (e) {
        e.preventDefault();
        var $this = $(this);
        var parentTr = $this.parent().parent().parent();
        var delete_url = $this.attr('link');
        var doing = false;

        if (!confirm('Are you sure you want delete? This action will delete data permanently and can\'t be undone.')) {
            return false;
        }

        if (doing == false) {
            doing = true;
            parentTr.hide('slow');

            $.ajax({
                url: delete_url,
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

});