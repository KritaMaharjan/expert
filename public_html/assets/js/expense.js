(function() {

    $('.business_div').hide();

    $(document).on('click', '#business', function () {
        parentDiv = $(this).parent().parent().parent();
        if ($(this).is(':checked')) {
            parentDiv.find('#type').val('2');
            parentDiv.find('.dob_div').hide();
            parentDiv.find('.business_div').show();
        } else {
            parentDiv.find('#type').val('1');
            parentDiv.find('.dob_div').show();
            parentDiv.find('.business_div').hide();
        }
    });

    $('.source').on('change', function(){
        var source = $(this).val();
        if(source == 'supplier')
            $('.supplier').show();
        else
            $('.supplier').hide();
    });

    //select2 for supplier
    var supplierSelect = $(".select-supplier");
    supplierSelect.select2({
        ajax: {
            url: appUrl + 'supplier/suggestions',
            dataType: 'json',
            cache: false,
            data: function (params) {
                return {
                    name: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data) {

                return {

                    results: $.map(data, function (obj) {
                        return {id: obj.id, text: obj.text};
                    })
                };
            }
        },

        formatResult: FormatResult,
        formatSelection: FormatSelection,
        escapeMarkup: function (m) {
            return m;
        },
        theme: "classic"
    });

    function FormatResult(item) {
        var markup = "";
        if (item.text !== undefined) {
            markup += "<option value='" + item.id + "'>" + item.text + "</option>";
        }
        return markup;
    }

    function FormatSelection(item) {
        return item.text;
    }

    $("#billing-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
    });
    $("#payment-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
    });
    $("#paid-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
    });
    $(".select-multiple").select2({
        theme: "classic"
    });

    $(document).on('ifChanged', '#paid-box .icheck', function (e) {
        $("#after-paid").slideToggle();
    });

    //add new supplier
    $(document).on('submit', '#supplier-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = form.attr('action');

        var formData = new FormData(form[0]);

        var requestType = form.find('.supplier-submit').val();
        form.find('.supplier-submit').val('loading...');
        form.find('.supplier-submit').attr('disabled', true);

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();
        form.find('.callout').remove();

        $.ajax({
            url: appUrl + 'supplier',
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
                    $('.mainContainer .box-solid').before(notify('success', 'Supplier added Successfully'));

                    $('.select-supplier').prepend('<option value="'+response.data.id+'">'+response.data.name+'</option>');
                    supplierSelect.val(response.data.id).trigger("change");
                }
                else {
                    if (response.status == 'fail') {
                        $.each(response.errors, function (i, v) {
                            $('.modal-body #' + i).parent().addClass('has-error');
                            $('.modal-body #' + i).after('<label class="error error-' + i + '">' + v + '<label>');
                        });
                    }
                }
            })
            .fail(function () {
                alert('something went wrong');
            })
            .always(function () {
                form.find('.supplier-submit').removeAttr('disabled');
                form.find('.supplier-submit').val(requestType);
            });
    });

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }


    var invoice_tr = $('.expense-table .position-r');
    var invoice_tr_html = invoice_tr.html();
    var invoice_tr_html_wrap = '<tr class="position-r">' + invoice_tr_html + '</tr>';
    var add_btn = $('.add-btn');


    add_btn.on('click', function () {
        var html_product = '<tr class="position-r"><td><input type="text" name="text[]" class="form-control"></td>' +
            '<td><input type="text" name="amount[]" class="form-control"></td>' +
            '<td><select name="vat[]" id="vat" class="form-control"><option value="8">8%</option><option value="15">15%</option><option value="25">25%</option><option value="0">Foreign/Domestic Exempt</option></select></td>' +
            '<td><span class="border-bx block total"> </span></td>' +
            '<td class="position-relative">' +
            '<div class="action-buttons"><a title="Delete" class="invoice-delete fa fa-close btn-danger delete" href="javascript:;"></a></div>' +
            '<select class="select-product form-control"><option>aasdf</option></select></td></tr>';
        // invoice_tr.after(invoice_tr_html_wrap);
        $('.expense-table tr:last').after(html_product);


        selectProduct();
    });

})();