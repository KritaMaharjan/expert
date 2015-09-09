/*add phone*/
$(document).on("click", "#ex-modal .modal-body .add-phone", function(e) {
    e.preventDefault();
    var newRow = '<div class="row phone-row">'+$('.phone-row').last().html()+'</div>';
    $('.phone-group').append(newRow);
});

/*remove phone*/
$(document).on("click", "#ex-modal .modal-body .remove-phone", function(e) {
    e.preventDefault();
    var numPhones = $('.modal-body .phone-row').length;
    if(numPhones > 1) {
        var parentRow = $(this).parent().parent();
        parentRow.fadeOut('slow', function() {
            parentRow.remove();
        });
    } else {
        alert('At least one phone number should be selected');
    }
});