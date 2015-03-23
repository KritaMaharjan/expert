(function () {
    $("#invoice-date-picker").datepicker({
        'format': 'yyyy-mm-dd'
        });
    $("#due-date-picker").datepicker({
        'format': 'yyyy-mm-dd'
    });

    var invoice_tr = $('.product-table .position-r');
    var invoice_tr_html = invoice_tr.html();
    var invoice_tr_html_wrap = '<tr class="position-r">' + invoice_tr_html + '</tr>';
    var add_btn = $('.add-btn');


    add_btn.on('click', function () {
        invoice_tr.after(invoice_tr_html_wrap);
        selectProduct();
    });

    //select2 for customer
    var customerSelect = $(".select-single");
    customerSelect.select2({
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
    $('table').on('click', 'tr .delete', function (e) {
        e.preventDefault();
        var rowCount = $('.product-table tr').length;
        if (rowCount > 2)
            $(this).closest('tr').remove();
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
                        $('#customer_id').val(response.details.id);
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
                url: appUrl + 'product/details/' + product_id,
                type: 'GET',
                dataType: 'json'
            })
                .done(function (response) {
                    if (response.success === true) {
                        /*$('#price').val(response.details.selling_price);
                         $('#vat').val(response.details.vat);*/
                        $this.parent().parent().find('.price').val(response.details.selling_price);
                        $this.parent().parent().find('.vat').val(response.details.vat);
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
        if(quantity < 1 || isNaN(quantity))
        {
            alert('Please select a number above 0.');
            $this.parent().parent().find('.total').val('');
        }
        else
        {
            var vat = parseFloat($this.parent().parent().find('.vat').val());
            var price = parseFloat($this.parent().parent().find('.price').val());
            var total = (price + vat * 0.01 * price) * quantity;
            $this.parent().parent().find('.total').val(total);
        }

        var allTotal = 0;
        var vatTotal = 0;
        var subtotal = 0;

        $(".total").each(function(){
            var thisTotal = parseFloat($(this).val());
            if(thisTotal > 0)
            {
                var vat = parseFloat($(this).parent().parent().find('.vat').val());
                var price = parseFloat($(this).parent().parent().find('.price').val());
                var thisQuantity = parseFloat($(this).parent().parent().find('.quantity').val());
                vatTotal = vatTotal + (vat * 0.01 * price * thisQuantity);
                allTotal = allTotal + thisTotal;
                subtotal = subtotal + price * thisQuantity;
            }
        });
        $('#subtotal').html(subtotal);
        $('#tax-amount').html(vatTotal);
        $('#all-total').html(allTotal);
    });

})();