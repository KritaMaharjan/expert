$('.date-picker').datepicker({format: 'yyyy-mm-dd', endDate: new Date()});

$('.expiry_date').datepicker({format: 'yyyy-mm-dd', startDate: new Date()});

$('.starting_date').datepicker({format: 'yyyy-mm-dd'});

$(document).ready(function() {
    /* Add Applicant */
    $('.add-applicant').click(function(e){
        e.preventDefault();
        $this = $(this);
        $this.html('Loading...');
        $this.attr('disabled', true);
        $.ajax({
            url: appUrl + '/system/application/applicant/template/'+ leadID,
            type: 'GET',
            dataType: 'json'
        })
            .done(function (response) {
                if (response.success == true || response.status == 1) {
                    var newApplicant = response.data.template;
                    var newApplicantElement = $(newApplicant).insertAfter($('.new-applicant').last());
                    var numApplicants = $('.applicant-details .new-applicant').length;
                    newApplicantElement.find('.applicant-num').html(numApplicants);

                    if(numApplicants == 10) {
                        $('.add-applicant-div').hide();
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
                $this.html('Add an Applicant');
                $this.attr('disabled', false);
            });
    });

    $(document).on('click', '.remove-applicant', function(e) {
        //$('.remove-applicant').click(function(e) {
        e.preventDefault();
        var numApplicants = $('.applicant-details .new-applicant').length;
        if(numApplicants == 1)
        {
            alert("At least one applicant is mandatory!");
            return false;
        }

        if (!confirm('Are you sure you want to remove this?')) return false;

        var parentDiv = $(this).closest('.new-applicant');
        parentDiv.hide('slow', function(){
            $(this).remove();
            $( ".new-applicant" ).each(function(index) {
                $(this).find('.applicant-num').html(index+1);
            });});
        if(numApplicants == 10) $('.add-applicant-div').show();
    });

    $(document).on('change', '.dependent', function(e) {
        if (this.value == 1) {
            $(this).parents().find('.dependant').fadeIn('slow');
        }
        else if (this.value == 0) {
            $(this).parents().find('.dependant').fadeOut('slow');
        }
    });

    $(document).on('change', 'input[type=radio][name="credit_card_issue[]"]', function(e) {
        if (this.value == "1") {
            $('.issue-comments').fadeIn('slow');
        }
        else if (this.value == "0") {
            $('.issue-comments').fadeOut('slow');
        }
    });

    $(document).on('click', '.add-dependant', function(e) {
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
