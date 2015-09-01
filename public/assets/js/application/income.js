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
        var numIncome_before_insert = $('.income-details .new-income').length;
        var newIncome = '<div class="new-income">'+$('.new-income').last().html()+'</div>';
        $ninc = $(newIncome);
        $ninc.find('.salary_credit').removeAttr('name').attr('name', 'salary_crediting['+numIncome_before_insert+']');
        var newIncomeElement = $ninc.insertAfter($('.new-income').last());
        var numIncomes = $('.income-details .new-income').length;
        newIncomeElement.find('.income-num').html(numIncomes);
        $('.date-picker').datepicker({format: 'yyyy-mm-dd'});

        if(numIncomes == 10) {
            $('.add-income-div').hide();
        }
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
