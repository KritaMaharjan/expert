(function() {

    //select2 for employee
    var employeeSelect = $("#select-employee");
    employeeSelect.select2({
        ajax: {
            url: appUrl + 'employee/suggestions',
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
        console.log(item.text)
        return item.text;
    }

    $("#paidout-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
    });

})();
