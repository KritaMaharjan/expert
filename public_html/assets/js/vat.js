(function() {

    $(function(){
        $("#billing-date-pickers").datepicker({
            "format": "yyyy-mm-dd"
        });

    });

    //filter vat entries
    $("#year, #period").on("change", function (e) {
    var employee_id = $("#select-employee").val();
    var year = $('#year').val();
    var period = $('#period').val();
    var doing = false;

    if (doing == false) {
        doing = true;
        $('.entries-info').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
        $.ajax({
            url: appUrl + 'accounting/vat/entries',
            type: 'POST',
            dataType: 'json',
            data: {year: year, period: period}
        })
            .done(function (response) {
                $('.entries-info').html(response.data.details);
            })
            .fail(function () {
                alert('something went wrong');
                $('.entries-info').html('');
            })
            .always(function () {
                doing = false;
            });
        }
    });

    //mark as sent
    $(document).on('submit', '#payment-form', function (e) {
        e.preventDefault();

        if (!confirm('Are you sure you want to perform the action? This action will affect data permanently and can\'t be undone.')) {
            return false;
        }

        var form = $(this);
        var dataAction = $(this).attr('dataAction');
        var formAction = appUrl + 'accounting/vat/action/'+dataAction;
        var formData = form.serialize();

        $('.box-solid .error').remove();
        form.find('.form-submit').html('Loading...');
        form.find('.form-submit').attr('disabled', 'disabled');

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();
        $('.callout').remove();

        $.ajax({
            url: formAction,
            type: 'POST',
            dataType: 'json',
            data: formData
        })
            .done(function (response) {
                if(response.status == 0)
                {
                    $.each(response.data.errors, function( index, value ) {
                        var errorDiv = '.box-solid #'+index;
                        $(errorDiv).closest( ".form-group" ).addClass('has-error');
                        $('.box-solid #'+index).after('<label class="error error-'+index+'">'+value+'<label>');
                    });
                }

                else {
                    $('.mainContainer .box-solid').before(notify('success', 'Marked Successfully!'));
                    //change the remaining amount
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                } //success
            })
            .fail(function () {
                alert('Something went wrong! Please try again later!');
            })
            .always(function () {
                form.find('.form-submit').removeAttr('disabled');
                form.find('.form-submit').html('Mark as '+dataAction);

            });
    });

})();