(function () {
    var invoice_tr = $('.product-table .position-r');
    var invoice_tr_html = invoice_tr.html();
    var invoice_tr_html_wrap = '<tr class="position-r">' + invoice_tr_html + '</tr>';
    var add_btn = $('.add-btn');

    add_btn.on('click', function () {
        invoice_tr.after(invoice_tr_html_wrap);
        selectProduct();
    });

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

    $('table').on('click','tr .delete',function(e){
        e.preventDefault();
        var rowCount = $('.product-table tr').length;
        if(rowCount > 2)
            $(this).closest('tr').remove();
        else
        alert("At least one product needs to be chosen.");
    });

    customerSelect.on("change", function(e) {
        var $this = $(this);
        var customer_id = $this.val();
        var doing = false;

        if (doing == false) {
            doing = true;
            $('.customer-info').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
            $.ajax({
                url: appUrl + 'customer/details/'+customer_id,
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

    function DetailsTemplate(details)
    {
        var template = '<strong>'+details.name+
        '</strong><br>' + details.street_name+' '+ details.street_number+
            '<br>' +details.town+'<br>Phone: ' +details.telephone+'<br>Email: ' +details.email;
        return template;
    }

    //if ($(".select-product").change() || $('#quantity').change()) {
    $(".select-product").on("change", function(e) {
            var $this = $(this);
            var product_id = $this.val();
            var doing = false;

            if (doing == false) {
                doing = true;
                $('.product-info').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
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
                        doing = false;
                    });
            }
    })

})();