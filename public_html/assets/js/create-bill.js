(function () {
    $('.add-quantity').attr('readonly', 'readonly');

    $("#invoice-date-picker").datepicker({
        'format': 'yyyy-mm-dd'
    });
    $('#due-date-pickers').datepicker({format: 'yyyy-mm-dd',startDate :new Date()});

    var invoice_tr = $('.product-table .position-r');
    var invoice_tr_html = invoice_tr.html();
    var invoice_tr_html_wrap = '<tr class="position-r">' + invoice_tr_html + '</tr>';
    var add_btn = $('.add-btn');


    add_btn.on('click', function () {
        var html_product = '<tr class="position-r"><td><select name="product[]" class="select-product form-control"><option value="">Select Product</option></select></td>' +
            '<td><input type="number" name="quantity[]" class="add-quantity quantity form-control" id="quantity" required="required" readonly="readonly"/>' +
            '<td><span class="border-bx block price"> </span></td>' +
            //'<td><span class="border-bx block vat"> </span></td>' +
            '<td class="position-relative">' +
            '<div class="action-buttons"><a title="Delete" class="invoice-delete fa fa-close btn-danger delete" href="javascript:;"></a></div>' +
            '<span class="border-bx block total"> </span></td></tr>';
        // invoice_tr.after(invoice_tr_html_wrap);
        $('.product-table tr:last').after(html_product);


        selectProduct();
    });

    //select2 for customer
    var customerSelect = $(".select-customer");
    customerSelect2 = customerSelect.select2({
        ajax: {
            url: appUrl + 'customer/suggestions',
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

    //Select2 for product
    function selectProduct() {
        $(".select-product").select2({
            ajax: {
                url: appUrl + 'product/suggestions',
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
    }

    //call it beforehand
    selectProduct();

    function FormatResult(item) {
        var markup = "";
        if (item.text !== undefined) {
            markup += "<option value='" + item.id + "'>" + item.text + "</option>";
        }
        return markup;
    }

    function FormatSelection(item) {
        console.log(item.text)
        return item.text;
    }

    //delete current product row
    $('table').on('click', 'tr .invoice-delete', function (e) {
        e.preventDefault();
        var rowCount = $('.product-table tr').length;
        if (rowCount > 2) {
            $(this).closest('tr').remove();
            changeSummary();
        }
        else
            alert("At least one product needs to be chosen.");
    });

    customerSelect.on("change", function (e) {
        var $this = $(this);
        var customer_id = $this.val();
        var doing = false;

        if (doing == false) {
            doing = true;
            $('.customer-info').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
            $.ajax({
                url: appUrl + 'customer/details/' + customer_id,
                type: 'GET',
                dataType: 'json'
            })
                .done(function (response) {
                    if (response.success === true) {
                        var addressInfo = DetailsTemplate(response.details);
                        $('.customer-info').html(addressInfo);
                        $('.cus-pay-no').html(response.details.paymentNo);
                        $('.invoice_number').html(response.details.invoiceNo);
                    } else {
                        alert('Something went wrong!');
                        $('.customer-info').html('');
                    }
                })
                .fail(function () {
                    alert('something went wrong');
                    $('.customer-info').html('');
                })
                .always(function () {
                    doing = false;
                });
        }

    });

    function DetailsTemplate(details) {
        var template = '<strong>' + details.name +
            '</strong><br>' + details.street_name + ' ' + details.street_number +
            '<br>' + details.town + '<br>Phone: ' + details.telephone + '<br>Email: ' + details.email;
        return template;
    }

    //change product details : vat and price for selected product
    $(document).on('change', '.select-product', function () {
        var $this = $(this);
        var product_id = $this.val();
        var productDoing = false;

        if (productDoing == false) {
            productDoing = true;
            $.ajax({
                url: appUrl + 'inventory/product/' + product_id + '/detail?json=1',
                type: 'GET',
                dataType: 'json'
            })
                .done(function (response) {
                    if (response.status == 1) {
                        /*$('#price').val(response.details.selling_price);
                         $('#vat').val(response.details.vat);*/
                        $this.parent().parent().find('.add-quantity').removeAttr('readonly', 'readonly');
                        $this.parent().parent().find('.price').html(parseFloat(response.data.selling_price).toFixed(2));
                        /*$this.parent().parent().find('.vat').html(parseFloat(response.data.vat).toFixed(2));*/
                    } else {
                        alert('Something went wrong!');
                    }
                })
                .fail(function () {
                    alert('something went wrong');
                })
                .always(function () {
                    productDoing = false;
                });
        }

    });

    //calculate the cost
    $(document).on('keyup', '#quantity', function () {
        var $this = $(this);
        var quantity = parseInt($this.val());
        if (quantity < 1 || isNaN(quantity)) {
            alert('Please select a number above 0.');
            $this.parent().parent().find('.total').html('');
        }
        else {
            //var vat = parseFloat($this.parent().parent().find('.vat').html());
            var price = parseFloat($this.parent().parent().find('.price').html());
            //var total = (price + vat * 0.01 * price) * quantity;
            var total = price * quantity;
            $this.parent().parent().find('.total').html(parseFloat(total).toFixed(2));
        }

        changeSummary();
    });

    $(document).on('change', '.vat', function () {
        changeSummary();
    });

    function changeSummary() {
        var allTotal = 0;
        var vatTotal = 0;
        var subtotal = 0;
        var totalQuantity = 0;

        $(".total").each(function () {
            var thisTotal = parseFloat($(this).html());
            if (thisTotal > 0) {
                //var vat = parseFloat($(this).parent().parent().find('.vat').html());
                var price = parseFloat($(this).parent().parent().find('.price').html());
                var thisQuantity = parseFloat($(this).parent().parent().find('.quantity').val());
                //vatTotal = vatTotal + (vat * 0.01 * price * thisQuantity);
                subtotal = subtotal + thisTotal;
                totalQuantity = totalQuantity + thisQuantity;
                //subtotal = subtotal + price * thisQuantity;
            }
        });

        var vat = parseFloat($('.vat').val());
        //withVat = (subtotal + vat * 0.01 * subtotal) * totalQuantity;
        vatTotal = vat * 0.01 * subtotal;
        allTotal = subtotal + vatTotal;
        $('#subtotal').html(subtotal.toFixed(2));
        $('#tax-amount').html(vatTotal.toFixed(2));
        $('#all-total').html(allTotal.toFixed(2));
    }

    $(document).on('submit', '#bill-form', function (e) {
        $('.bill-submit').val('loading...').attr('disabled', true);
    });

    //creation of customer
    $(document).on('submit', '#customer-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = appUrl + 'customer';

        var formData = new FormData(form[0]);
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
                    $('.mainContainer .box-solid').before(notify('success', 'Customer added Successfully'));
                    $('#customer').prepend('<option value="'+response.data.id+'">'+response.data.customerName+'</option>');
                    var select = customerSelect;
                    select.val(response.data.id).trigger("change");

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
                }
            })
            .fail(function () {
                alert('something went wrong');
            })
            .always(function () {
                form.find('.customer-submit').removeAttr('disabled');
                form.find('.customer-submit').val(requestType);
            });
    });

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }

})();