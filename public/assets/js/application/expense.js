$('.date-picker').datepicker({format: 'yyyy-mm-dd'});

$(document).ready(function() {

    $('input[type=radio][name=expense]').change(function() {
        if (this.value == 1) {
            $('.expense-details').fadeIn('slow');
        }
        else if (this.value == 0) {
            $('.expense-details').fadeOut('slow');
        }
    });

    $('.add-expense').click(function(e){
        e.preventDefault();
        $this = $(this);
        $this.html('Loading...');
        $this.attr('disabled', true);
        $.ajax({
            url: appUrl + '/system/application/expense/template/'+ leadID,
            type: 'GET',
            dataType: 'json'
        })
            .done(function (response) {
                if (response.success == true || response.status == 1) {
                    var newIncome = response.data.template;
                    var newIncomeElement = $(newIncome).insertAfter($('.new-expense').last());
                    var numIncomes = $('.expense-details .new-expense').length;
                    newIncomeElement.find('.expense-num').html(numIncomes);
                    $('.date-picker').datepicker({format: 'yyyy-mm-dd'});

                    if(numIncomes == 10) {
                        $('.add-expense-div').hide();
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
                $this.html('Add an Expense');
                $this.attr('disabled', false);
            });
    });

    $(document).on('click', '.remove-expense', function(e) {
    //$('.remove-expense').click(function(e) {
        e.preventDefault();
        var numIncomes = $('.expense-details .new-expense').length;
        if(numIncomes == 1)
        {
            $('input[type=radio][name=expense][value = "0"]').prop('checked', true);
            $('.expense-details').fadeOut('slow');
            return false;
        }

        if (!confirm('Are you sure you want to remove this?')) return false;

        var parentDiv = $(this).parent().parent().parent();
        parentDiv.hide('slow', function(){
            $(this).remove();
            $( ".new-expense" ).each(function(index) {
            $(this).find('.expense-num').html(index+1);
        });});
        if(numIncomes == 10) $('.add-expense-div').show();
    });

});
