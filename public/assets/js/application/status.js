$('input').on('ifChecked', function(event){
    var confirmed = confirm("Are you sure you want to perform this action? You cannot undo it.");
    if (!confirmed) {
        $('.status').iCheck('uncheck');
        return false;
    }
    var status = $(this).val();
    $.ajax({
        url: appUrl + '/system/application/status',
        type: 'POST',
        data: { status: status, application_id: application_id },
        dataType: 'json'
    })
        .done(function (response) {
            if (response.success == true || response.status == 1) {
                window.location.reload(true);
            }
        })
        .fail(function () {
            alert('Something went wrong!');
        })
});
