$('.date-picker').datepicker({format: 'yyyy-mm-dd', endDate: new Date()});

$('.expiry_date').datepicker({format: 'yyyy-mm-dd', startDate: new Date()});

$('.starting_date').datepicker({format: 'yyyy-mm-dd'});

$(document).ready(function() {
    $('input[type=radio][name=dependent]').change(function() {
        if (this.value == 'yes') {
            $('.dependant').fadeIn('slow');
        }
        else if (this.value == 'no') {
            $('.dependant').fadeOut('slow');
        }
    });

    $('input[type=radio][name=credit_card_issue]').change(function() {
        if (this.value == "1") {
            $('.issue-comments').fadeIn('slow');
        }
        else if (this.value == "0") {
            $('.issue-comments').fadeOut('slow');
        }
    });

    $('.add-dependant').click(function(e) {
        e.preventDefault();
        $('.ages').append('<input type="text" name="age[]" class="form-control text-digit" />');
    });

    /*add phone*/
    $(document).on("click", ".add-phone", function(e) {
        e.preventDefault();
        var newRow = '<div class="row phone-row form-group">'+$('.phone-row').last().html()+'</div>';
        $('.phone-group').append(newRow);
    });

    /*remove phone*/
    $(document).on("click", ".remove-phone", function(e) {
        e.preventDefault();
        var numPhones = $('.phone-row').length;
        if(numPhones > 1) {
            var parentRow = $(this).parent().parent();
            parentRow.fadeOut('slow', function() {
                parentRow.remove();
            });
        } else {
            alert('At least one phone number should be selected');
        }
    });
});
