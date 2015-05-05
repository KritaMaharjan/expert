$(function () {

    var collectionDatatable = $("#table-collection").DataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "order": [[6, "desc"]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'collection/data',
            "type": "POST"
        },
        "columnDefs": [{
            "targets": 1,
            "render": function (data, type, row) {
                return '<a href="#" class="link">' + row.invoice_number + '</a>';
            }
        }],

        "columns": [
            {"data": "id"},
            {"data": "invoice_number"},
            {"data": "customer_name"},
            {"data": "total"},
            {"data": "paid"},
            {"data": "remaining"},
            {"data": "due_date"}
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            $(nRow).attr('id', 'collection-' + aData.id);
            return nRow;
        },

    });


    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }

    $('#table-collection tbody').on('click', '.link', function (event) {
        event.preventDefault();
        var tr = $(this).closest('tr');
        var row = collectionDatatable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child(format(row.data())).show();
            $('.datepicker').datepicker({format: 'yyyy-mm-dd', endDate: new Date(), todayHighlight: true});
            tr.addClass('shown');
        }
    });

    function format(d) {
        var token = $('meta[name="csrf-token"]').attr('content');
        var payment_option = '<div class="payment-info" style="display: none;">' +
            '<form class="payment-form" id="' + d.id + '" method="post" action="">' +
            '<input type="hidden" name="_token" value="' + token + '">' +
            '<div class="form-group"><label> Payment date </label><input name="payment_date" id="payment_date" type="text" class="datepicker form-control"></div>' +
            '<div class="form-group"><label> Amount paid </label><input name="paid_amount" id="paid_amount" type="number" class="form-control"></div>' +
            '<div class="bottom-section clearfix">' +
            '<button class="btn-small btn btn-primary" id="payment-submit">Account as paid</button>' +
            '</form></div>';

        var bill = d.id;

        $hidden_child = '<tr class="temp_tr">' +
        '<td colspan="7"><div class="clearfix">' +
        '<ul class="links-td">' +
        '<li><a class="link-block" href="#">Register payment</a></li>' +
        '<li><a href="' + appUrl + 'collection/purring/pdf?bill=' + bill + '&token=' + token + '">Create a Purring.pdf</a></li>' +
        '<li><a href="' + appUrl + 'collection/gotostep/inkassovarsel?bill=' + bill + '&token=' + token + '">Skip this step</a></li>' +
        '<li><a href="' + appUrl + 'collection/dispute?bill=' + bill + '&token=' + token + '">Register dispute</a></li>' +
        '<li><a href="' + appUrl + 'collection/cancel?bill=' + bill + '&token=' + token + '">Cancel Collection Case</a></li>' +

        '</ul>' +
        payment_option +
        '</div></td></tr>';
        return $hidden_child;

    }

    $(document).on('click', '#payment-submit', function (e) {
        e.preventDefault();
        $('.erroring').remove();
        var form = $(this).parent().parent('.payment-form');
        var token = form.find('input[name="_token"]').val();
        var billId = form.attr('id');
        var formAction = appUrl + "invoice/bill/" + billId + "/payment";
        var formData = form.serialize();

        var requestType = form.find('#payment-submit').val();

        form.find('#payment-submit').val('loading...');
        form.find('#payment-submit').attr('disabled', true);

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
                if (response.success == true || response.status == 1) {
                    $('.error').remove();
                    form.parent().hide();
                    $('.mainContainer .box-solid').before(notify('success', 'Payment Added Successfully!'));
                    setTimeout(function () {
                        $('.callout').remove();
                    }, 3000);

                }
                else {
                    if (response.status == false) {
                        $('.error').remove();
                        $.each(response.data.errors, function (i, v) {
                            // form.closest('form').find('input[name='+i+']').after('<label class="error ">'+v+'</label>');
                            $('#' + i).parent().addClass('has-error');
                            $('#' + i).after('<label class="error erroring error-' + i + '">' + v + '<label>');
                        });
                    }
                }
            })
            .fail(function () {
                alert('Something went wrong!');
            })
            .always(function () {
                form.find('#payment-submit').removeAttr('disabled');
                form.find('#payment-submit').val(requestType);
            });
    });

    $(document).on('click', '.link-block', function (e) {
        e.preventDefault();
        $(this).parent().parent().parent().find('.payment-info').toggle();
    });
});
