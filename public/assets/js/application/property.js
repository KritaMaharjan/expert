$('.expiry_date').datepicker({format: 'yyyy-mm-dd', startDate: new Date()});

$(document).ready(function() {
    $(document).on('change', '.rental_income', function(e) {
        if (this.value == 1) {
            $(this).closest('.box-body').find('.rental-details').fadeIn('slow');
        }
        else if (this.value == 0) {
            $(this).closest('.box-body').find('.rental-details').fadeOut('slow');
        }
    });

    $(document).on('change', '.existing_loans', function(e) {
        if (this.value == 1) {
            $(this).closest('.box-body').find('.loans-details').fadeIn('slow');
        }
        else if (this.value == 0) {
            $(this).closest('.box-body').find('.loans-details').fadeIn('slow');
        }
    });

    $('.add-property').click(function(e){
        e.preventDefault();
        $this = $(this);
        $this.html('Loading...');
        $this.attr('disabled', true);
        $.ajax({
            url: appUrl + '/system/application/property/template/'+ leadID,
            type: 'GET',
            dataType: 'json'
        })
            .done(function (response) {
                if (response.success == true || response.status == 1) {
                    var newProperty = response.data.template;
                    var newPropertyElement = $(newProperty).insertAfter($('.new-property').last());
                    var numProperties = $('.property-details .new-property').length;
                    newPropertyElement.find('.property-num').html(numProperties);

                    if(numProperties == 10) {
                        $('.add-property-div').hide();
                    }
                }
                else {
                    $('.mainContainer .box-solid').before(notify('error', 'Something went wrong!'));
                    setTimeout(function () {
                        $('.callout').remove();
                    }, 3000);
                }
            })
            .fail(function () {
                alert('Something went wrong!');
            })
            .always(function() {
                $this.html('Add a Property');
                $this.attr('disabled', false);
            });
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
