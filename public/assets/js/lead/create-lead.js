/* Add client */
$(document).on('submit', '#client-form', function (e) {
    e.preventDefault();
    var form = $(this);
    var formAction = appUrl + '/system/client/add';

    var formData = new FormData(form[0]);

    form.find('.client-submit').val('loading...');
    form.find('.client-submit').attr('disabled', true);

    form.find('.has-error').removeClass('has-error');
    form.find('label.error').remove();
    form.find('.callout').remove();


    $.ajax({
        url: formAction,
        type: 'POST',
        dataType: 'json',
        data: formData,

        //required for ajax file upload
        processData: false,
        contentType: false
    })
        .done(function (response) {
            if (response.success == true || response.status == 1) {

                $('#ex-modal').modal('hide');
                $('.mainContainer .box-solid').before(notify('success', 'Client added Successfully'));
                $('#client-select').prepend('<option value="'+response.data.id+'" selected="selected">'+response.data.clientName+'</option>');

                setTimeout(function () {
                    $('.callout').remove()
                }, 2500);
            }
            else {
                if (response.status == 'fail') {
                    $.each(response.errors, function (i, v) {
                        // form.closest('form').find('input[name='+i+']').after('<label class="error ">'+v+'</label>');
                        $('.modal-body #' + i).parent().addClass('has-error')
                        $('.modal-body #' + i).after('<label class="error error-' + i + '">' + v + '<label>');
                    });
                }
            }
        })
        .fail(function () {
            alert('something went wrong');
        })
        .always(function () {
            form.find('.client-submit').removeAttr('disabled');
            form.find('.client-submit').val('Add Client');
        });

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }

});