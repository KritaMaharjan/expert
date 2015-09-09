/* Delete log */
$(document).on('click', '.delete-log', function (e) {
    e.preventDefault();
    var $this = $(this);
    var parentTr = $this.parent().parent();
    var url = $this.attr('href');
    var doing = false;

    if (!confirm('Are you sure? This action will delete data permanently and can\'t be undone.')) {
        return false;
    }

    if (doing == false) {
        doing = true;
        parentTr.hide('slow');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json'
        })
            .done(function (response) {
                if (response.status === 1) {
                    $('.mainContainer .box-solid').before(notify('success', response.data.message));
                    parentTr.remove();
                } else {
                    $('.mainContainer .box-solid').before(notify('error', response.data.message));
                    parentTr.show('fast');
                }
                setTimeout(function () {
                    $('.callout').remove()
                }, 2500);
            })
            .fail(function () {
                parentTr.show('fast');
                alert('Something went wrong');
            })
            .always(function () {
                doing = false;
            });
    }

});

function notify(type, text) {
    return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
}