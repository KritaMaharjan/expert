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
        theme: "classic"
    });

})();