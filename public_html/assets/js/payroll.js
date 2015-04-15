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

    $("#paidout-date-pickers").datepicker({
        "format": "yyyy-mm-dd"
    });

    // on change for type
    $('.type').on('change', function (e) {
        var type = this.value;
        if(type == 0) //hourly
        {
            $('.rate').html('Rate per hour');
            $('.worked').html('Hours');
        }
        else if (type == 1) //monthly
        {
            $('.rate').html('Rate per month');
            $('.worked').html('Months');
        }
    });

    //salary calculation
    $('input[name=worked], input[name=rate], input[name=other_payment]').on('keyup', function (e) {
        var worked = $('input[name=worked]').val();
        var rate = $('input[name=rate]').val();
        var other_payment = parseFloat($('input[name=other_payment]').val());
        var vacation_rate = 0.102;
        var vacation_fund = parseFloat(worked * rate * vacation_rate);

        $('input[name=vacation_fund]').val(vacation_fund);
        var salary = parseFloat((worked * rate) + vacation_fund +other_payment).toFixed(2);
        $('input[name=basic_salary]').val(salary);
    });

})();
