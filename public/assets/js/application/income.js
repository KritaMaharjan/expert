$('.date-picker').datepicker({format: 'yyyy-mm-dd'});

$(document).ready(function() {

    $('input[type=radio][name=income]').change(function() {
        if (this.value == 1) {
            $('.income-details').fadeIn('slow');
        }
        else if (this.value == 0) {
            $('.income-details').fadeOut('slow');
        }
    });

    $('.add-income').click(function(e){
        e.preventDefault();
        $this = $(this);
        $this.html('Loading...');
        $this.attr('disabled', true);
        $.ajax({
            url: appUrl + '/system/application/income/template/'+ leadID,
            type: 'GET',
            dataType: 'json'
        })
            .done(function (response) {
                if (response.success == true || response.status == 1) {
                    var newIncome = response.data.template;
                    var newIncomeElement = $(newIncome).insertAfter($('.new-income').last());
                    var numIncomes = $('.income-details .new-income').length;
                    newIncomeElement.find('.income-num').html(numIncomes);
                    $('.date-picker').datepicker({format: 'yyyy-mm-dd'});

                    if(numIncomes == 10) {
                        $('.add-income-div').hide();
                    }
                }
                else {
                    $('.mainContainer .box-solid').before(notify('error', 'Something went wrong!'));
                }
            })
            .fail(function () {
                alert('Something went wrong!');
            })
            .always(function() {
                $this.html('Add an Income Source');
                $this.attr('disabled', false);
            });
    });

    $(document).on('click', '.remove-income', function(e) {
    //$('.remove-income').click(function(e) {
        e.preventDefault();
        var numIncomes = $('.income-details .new-income').length;
        if(numIncomes == 1)
        {
            $('input[type=radio][name=income][value = "0"]').prop('checked', true);
            $('.income-details').fadeOut('slow');
            return false;
        }

        if (!confirm('Are you sure you want to remove this?')) return false;

        var parentDiv = $(this).parent().parent().parent();
        parentDiv.hide('slow', function(){
            $(this).remove();
            $( ".new-income" ).each(function(index) {
            $(this).find('.income-num').html(index+1);
        });});
        if(numIncomes == 10) $('.add-income-div').show();
    });

});
