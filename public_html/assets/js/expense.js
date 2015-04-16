(function() {

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
})();