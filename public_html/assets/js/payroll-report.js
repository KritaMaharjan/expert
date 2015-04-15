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
    employeeSelect.on("change", function (e) {
        var $this = $(this);
        var employee_id = $this.val();
        var doing = false;

        if (doing == false) {
            doing = true;
            $('.payout-info').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
            $.ajax({
                url: appUrl + 'payout/details/' + employee_id,
                type: 'GET',
                dataType: 'json'
            })
                .done(function (response) {
                    if (response.success === true) {
                        //var addressInfo = DetailsTemplate(response.details);
                        $('.payout-info').html('ing');
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

    });

    function DetailsTemplate(details) {
        var template = '<strong>' + details.name +
            '</strong><br>' + details.street_name + ' ' + details.street_number +
            '<br>' + details.town + '<br>Phone: ' + details.telephone + '<br>Email: ' + details.email;
        return template;
    }

})();