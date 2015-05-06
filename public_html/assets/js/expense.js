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
        if(source == 1)
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

    $(".date-picker").datepicker({
        "format": "yyyy-mm-dd"
    });

    function selectProduct() {
        $(".select-product").select2({
            theme: "classic"
        });
    }

    selectProduct();

    $(document).on('ifChecked', '#paid-box .icheck', function (e) {
        $("#after-paid").show("slow");
    });

    $(document).on('ifUnchecked', '#paid-box .icheck', function (e) {
        $("#after-paid").hide("slow");
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
    var account_code_html = invoice_tr.find('#account-code').html();
    var add_btn = $('.add-btn');

    add_btn.on('click', function () {
        var html_product = '<tr class="position-r"><td><input type="text" name="text[]" class="form-control" required="required" /></td>' +
            '<td><input type="text" name="amount[]" class="form-control" id="amount" maxlength="7" required="required" /></td>' +
            '<td class="position-relative">' +
            '<div class="action-buttons"><a title="Delete" class="invoice-delete fa fa-close btn-danger delete" href="javascript:;"></a></div>' +
            '<select class="select-product form-control" required="required" >'+account_code_html+'</select></td></tr>';
            // invoice_tr.after(invoice_tr_html_wrap);
            var $this = $('.expense-table tr:last').after(html_product);
            $('.expense-table tr:last .select-product option:selected').removeAttr('selected');
            $('.expense-table tr:last #vat option:selected').removeAttr('selected');
            selectProduct();
    });

    //delete current product row
    $('table').on('click', 'tr .invoice-delete', function (e) {
        e.preventDefault();
        var rowCount = $('.expense-table tr').length;
        if (rowCount > 2)
            $(this).closest('tr').remove();
        else
            alert("At least one product needs to be chosen.");
    });

    //calculate the cost
    /*$(document).on('change', '#amount, #vat', function () {
        var $this = $(this);
        var parent = $this.parent().parent();
        var amount = parseFloat(parent.find('#amount').val());
        var vat = parseFloat(parent.find('#vat').val());

        if (amount < 1 || isNaN(amount)) {
            alert('Please select a number at least 1.');
        }
        else {
            var total = (amount + vat * 0.01 * amount);
            parent.find('.total').html(parseFloat(total).toFixed(2));
        }
    });*/

    //submit the form
    $(document).on('submit', '#expense-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = form.attr('action');
        var formData = form.serialize();

        $('.error').remove();
        form.find('.expense-submit').html('Loading...');
        form.find('.expense-submit').attr('disabled', 'disabled');

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
                        var errorDiv = '.box-body #'+index;
                        $(errorDiv).closest( ".form-group" ).addClass('has-error');
                        $('.box-body #'+index).after('<label class="error error-'+index+'">'+value+'<label>');
                    });
                }

                else {
                    //$('.mainContainer .box-solid').before(notify('success', 'Payment added Successfully!'));
                    window.location.replace(appUrl + 'accounting');
                } //success
            })
            .fail(function () {
                alert('Something went wrong! Please try again later!');
            })
            .always(function () {
                form.find('.expense-submit').removeAttr('disabled');
                form.find('.expense-submit').html('Register expense');

            });
    });

})();