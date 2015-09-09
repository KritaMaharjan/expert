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

    /* Add Property */
    $('.add-property').click(function(e){
        e.preventDefault();
        var newProperty = '<div class="new-property">'+$('.new-property').last().html()+'</div>';
        var newPropertyElement = $(newProperty).insertAfter($('.new-property').last());
        var numProperties = $('.property-details .new-property').length;
        newPropertyElement.find('.property-num').html(numProperties);

        if(numProperties == 10) {
            $('.add-property-div').hide();
        }
    });

    $(document).on('click', '.remove-property', function(e) {
        //$('.remove-property').click(function(e) {
        e.preventDefault();
        var numProperties = $('.property-details .new-property').length;
        if(numProperties == 1)
        {
            alert("At least one property is mandatory!");
            return false;
        }

        if (!confirm('Are you sure you want to remove this?')) return false;

        var parentDiv = $(this).closest('.new-property');
        parentDiv.hide('slow', function(){
            $(this).remove();
            $( ".new-property" ).each(function(index) {
                $(this).find('.property-num').html(index+1);
            });});
        if(numProperties == 10) $('.add-property-div').show();
    });
});
