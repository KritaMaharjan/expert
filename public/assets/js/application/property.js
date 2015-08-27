$('.expiry_date').datepicker({format: 'yyyy-mm-dd', startDate: new Date()});

$(document).ready(function() {
    $('input[type=radio][name=rental_income]').change(function() {
        if (this.value == 1) {
            $('.rental-details').fadeIn('slow');
        }
        else if (this.value == 0) {
            $('.rental-details').fadeOut('slow');
        }
    });

    $('input[type=radio][name=existing_loans]').change(function() {
        if (this.value == 1) {
            $('.loans-details').fadeIn('slow');
        }
        else if (this.value == 0) {
            $('.loans-details').fadeOut('slow');
        }
    });
});
