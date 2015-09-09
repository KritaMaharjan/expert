$('.expiry_date').datepicker({format: 'yyyy-mm-dd', startDate: new Date()});

$(document).ready(function() {

    /* Add Loan */
    $('.add-loan').click(function(e){
        e.preventDefault();
        var newLoan = '<div class="new-loan">'+$('.new-loan').last().html()+'</div>';
        var numLoansBefore = $('.loan-details .new-loan').length;
        $nl = $(newLoan);
        $nl.find('.loan_type').removeAttr('name').attr('name', 'loan_type['+numLoansBefore+']');
        $nl.find('.repayment_type').removeAttr('name').attr('name', 'repayment_type['+numLoansBefore+']');
        var newLoanElement = $nl.insertAfter($('.new-loan').last());

        var numLoans = $('.loan-details .new-loan').length;
        newLoanElement.find('.loan-num').html(numLoans);

        $('.expiry_date').datepicker({format: 'yyyy-mm-dd', startDate: new Date()});
        if(numLoans == 10) {
            $('.add-loan-div').hide();
        }
    });

    function chainItWithId(id) {

    }

    $(document).on('click', '.remove-loan', function(e) {
        //$('.remove-loan').click(function(e) {
        e.preventDefault();
        var numProperties = $('.loan-details .new-loan').length;
        if(numProperties == 1)
        {
            alert("At least one loan is mandatory!");
            return false;
        }

        if (!confirm('Are you sure you want to remove this?')) return false;

        var parentDiv = $(this).closest('.new-loan');
        parentDiv.hide('slow', function(){
            $(this).remove();
            $( ".new-loan" ).each(function(index) {
                $(this).find('.loan-num').html(index+1);
                $(this).find('.loan_type').removeAttr('name').attr('name', 'loan_type['+index+']');
                $(this).find('.repayment_type').removeAttr('name').attr('name', 'repayment_type['+index+']');
            });});
        if(numProperties == 10) $('.add-loan-div').show();
    });
});
