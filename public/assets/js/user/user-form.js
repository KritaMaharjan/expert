$(function () {

    /*add phone*/
    $(document).on("click", ".add-phone", function(e) {
        e.preventDefault();
        var newRow = '<div class="row phone-row">'+$('.phone-row').last().html()+'</div>';
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
            alert('At least one phone number should be selected.');
        }
    });
});