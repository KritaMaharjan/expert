(function () {
    var invoice_tr_html = $('.invoice-table .position-r').html();
    var invoice_tr_html_wrap = '<tr class="position-r">' + invoice_tr_html + '</tr>';
    var invoice_tr = $('.invoice-table .position-r');
    var add_btn = $('.add-btn');

    add_btn.on('click', function () {
        invoice_tr.after(invoice_tr_html_wrap);
    });
    invoice_tr.on('mouseover', function () {
        $(this).find('.action-buttons').show();
    });

    invoice_tr.on('mouseout', function () {
        $(this).find('.action-buttons').hide();
    });

    $(".select-single").select2({
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
                        return {id: obj.text, text: obj.text};
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
            markup += "<option value='" + item.text + "'>" + item.text + "</option>";
        }
        return markup;
    }

    function FormatSelection(item) {
        console.log(item.text)
        return item.text;
    }

})();