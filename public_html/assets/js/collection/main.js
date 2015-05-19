$(function () {

    function input_get(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }


    function getColumns()
    {
       var columns = [
            {"data": "invoice_number"},
            {"data": "customer_name"},
            {"data": "bill_total"},
            {"data": "fee"},
            {"data": "interest"},
            {"data": "paid"},
            {"data": "remaining"},
            {"data": "due_date"},
            {"data": "deadline"}
        ];

        if(input_get('step') == 'court' || input_get('step') == 'utlegg')
        {
            columns.splice(8, 1);
        }

        return columns;
    }

    function getDisableColumns()
    {
        var columns = [3,4,6,8];

        if(input_get('step') == 'court' || input_get('step') == 'utlegg')
        {
            columns.splice(3, 1);
        }

        return columns;

    }


    var collectionDatatable = $("#table-collection").DataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "order": [[0, "desc"]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'collection/data?step=' + input_get('step'),
            "type": "POST"
        },
        "columnDefs": [{
            "targets": 0,
            "render": function (data, type, row) {
                return '<a href="#" class="link">' + row.invoice_number + '</a>';
            }},
            {
                "targets": getDisableColumns(),
                "orderable": false
        }],

        "columns": getColumns(),
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            $(nRow).attr('id', 'collection-' + aData.id);
            return nRow;
        }

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
            $('.datepickerGreater').datepicker({format: 'yyyy-mm-dd', startDate: new Date(), todayHighlight: true});
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

        var goToStep = '';
        var register_dispute = '';
        var register_payment = '<li><a class="link-block" href="#">Register payment</a></li>';
        var create_pdf = '<li><a href="' + appUrl + 'collection/' + d.step + '/pdf?bill=' + bill + '&token=' + token + '">Create a ' + d.step + '.pdf</a></li>' ;

        if(d.step == 'betalingsappfording')
        {
            register_dispute =  '<li>' +
            '<a href="#"  data-original-title="Court Case" data-target="#fb-modal" data-toggle="modal" data-url="' + appUrl + 'collection/dispute?bill=' + bill + '&token=' + token + '">Court Case</a>' +
            ' OR ' +
            '<a href="' + appUrl + 'collection/gotostep/utlegg?bill=' + bill + '&token=' + token + '">Send directly to sheriff </a>';
            '</li>';
        }
        else if(d.step == 'court') {
            if(d.payment_date =='')
            {
                register_dispute = '<li><a class="register-case-won" href="#"> Register case won</a>' +
                '<form  class="case-won" data-id="' + d.id + '" method="post" action="">' +
                '<input type="hidden" name="_token" value="' + token + '">' +
                '<div class="form-group"><label> Payment date </label><input name="payment_date" id="payment_date" type="text" class="datepickerGreater form-control"></div>' +
                '<div class="bottom-section clearfix">' +
                '<button class="btn-small btn btn-primary">Save</button>' +
                '</form>'+
                ' </li>' +
                '<li><a href="#" data-original-title="Register court date" data-target="#fb-modal" data-toggle="modal" data-url="' + appUrl + 'collection/case/register-date?bill=' + bill + '&token=' + token + '">Register court date </a> </li>' ;
                register_payment='';
            }
            else
            {
                if(d.is_payment_date_exceed == true)
                {
                    register_payment='<li><a href="' + appUrl + 'collection/gotostep/utlegg?bill=' + bill + '&token=' + token + '">Send directly to sheriff </a></li>';
                }
            }
            register_dispute += '<li><a href="#"  data-original-title="Case history" data-target="#fb-modal" data-toggle="modal" data-url="' + appUrl + 'collection/case/history?bill=' + bill + '&token=' + token + '">Case history</a></li>';
            create_pdf= '';
        }
        else if(d.step == 'utlegg') {
            register_dispute =  '<li><a href="#"  data-original-title="Case is going to court" data-target="#fb-modal" data-toggle="modal" data-url="' + appUrl + 'collection/dispute?bill=' + bill + '&token=' + token + '">Case is going to court</a></li>';
        }
        else
        {
            register_dispute =  '<li><a href="#"  data-original-title="Register Dispute" data-target="#fb-modal" data-toggle="modal" data-url="' + appUrl + 'collection/dispute?bill=' + bill + '&token=' + token + '">Register dispute</a></li>';

            if (d.isGoToStep == 1) {
                goToStep = '<li><a href="' + appUrl + 'collection/gotostep/' + d.goToStep + '?bill=' + bill + '&token=' + token + '">Take the case to the next step</a></li>';
            }
        }

        $hidden_child = '<tr class="temp_tr">' +
        '<td colspan="7"><div class="clearfix">' +
        '<ul class="links-td">' +
        register_payment +
        create_pdf +
        goToStep +
        register_dispute+
        '<li><a data-confirm="yes" data-confirm-message="Collection progress will be canceled and Amount will be treated as loss. \nAre you sure, you want to perform this action?"  href="' + appUrl + 'collection/cancel?bill=' + bill + '&token=' + token + '">Cancel Case</a></li>' +
        '</ul>' +
        payment_option +
        '</div></td></tr>';
        return $hidden_child;
    }

    $(document).on('click', '.register-case-won', function(e){
        e.preventDefault();
        $('.case-won').toggle();
    })

    $(document).on('submit', '.case-won', function(e){
        e.preventDefault();
        var form = $(this);
        var billId = form.data('id');
        var formAction = appUrl + "collection/case/" + billId + "/payment-date";
        var formData = form.serialize();
        var submitBtn = form.find('.btn-primary');
        var requestType = submitBtn.val();

        submitBtn.val('loading...');
        submitBtn.attr('disabled', true);

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
                if (response.status == 1) {
                    form.parent().html('<a class="link-block" href="#">Register payment</a>');
                    $('#app-content .content').prepend(notify('success', 'Payment date added.'));
                    setTimeout(function () {
                        $('.callout').remove();
                    }, 3000);

                }
                else {
                    if ("errors" in response.data) {

                        $.each(response.data.errors, function (id, error) {
                            form.find('#' + id).parent().addClass('has-error')
                            form.find('#' + id).after('<label class="error error-' + id + '">' + error[0] + '<label>');
                        })
                    }

                    if ("error" in response.data) {
                        form.prepend(notify('danger', response.data.error));
                    }
                }
            })
            .fail(function () {
                form.prepend(notify('danger', 'Connection error!'));
            })
            .always(function () {
                submitBtn.removeAttr('disabled');
                submitBtn.val(requestType);
            });
    })

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

    $(document).on('click', '[data-confirm="yes"]', function (e) {
        var message = $(this).data('confirm-message');
        if (!confirm(message)) {
            e.preventDefault();
        }

    });


});
