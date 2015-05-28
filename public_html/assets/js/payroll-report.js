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
        return item.text;
    }

    //display payroll details
    $("#select-employee, #year, #month").on("change", function (e) {
        var employee_id = $("#select-employee").val();
        var year = $('#year').val();
        var month = $('#month').val();

        if(employee_id != '') {
            var doing = false;

            if (doing == false) {
                doing = true;
                $('.payout-info').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                $.ajax({
                    url: appUrl + 'payout/details/' + employee_id,
                    type: 'GET',
                    dataType: 'json',
                    data: {year: year, month: month}
                })
                    .done(function (response) {
                        if (response.status == 1) {
                            $('.payout-info').html(response.data.details);
                        } else {
                            alert('Something went wrong!');
                            $('.payout-info').html('');
                        }
                    })
                    .fail(function () {
                        alert('something went wrong');
                        $('.payout-info').html('');
                    })
                    .always(function () {
                        doing = false;
                    });
            }
        }

    });

})();