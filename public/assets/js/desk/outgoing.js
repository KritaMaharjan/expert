var personal_type = 0, support_type = 1;

// load emails
$(function () {

    loadEmailList(0, 1);

    $('.inbox').on('click', function () {

        if (!$(this).hasClass('btn-primary')) {
            $('.inbox').removeClass('btn-primary');

            $(this).addClass('btn-primary');

            var type = $(this).attr('id');
            if (type == "personal") {
                loadEmailList(personal_type, 1);
            }
            else {
                loadEmailList(support_type, 1);
            }
        }

    });

    $(document).on('click', '.table-mailbox a', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        if (!$('#email-single').hasClass('email-' + id)) {
            $('#email-single').load(appUrl + 'desk/email/' + id + '/show');
            $('#email-single').removeClass(function (index, css) {
                return (css.match(/(^|\s)email-\S+/g) || []).join(' ');
            });
            $('#email-single').addClass('email-' + id);
        }
    });


    // Delete Email

    $(document).on('click', '.email-delete', function (e) {
        e.preventDefault();

        if (!confirm('Are you sure, you want to delete email permanently?')) return false;

        var id = $(this).data('id');
        $.ajax({
            url: appUrl + 'desk/email/' + id + '/delete',
            type: 'GET',
            dataType: 'json',
        })
            .done(function (response) {
                if (response.status == 1) {
                    $('#email-single').html('');
                    $('#email-single').removeClass(function (index, css) {
                        return (css.match(/(^|\s)email-\S+/g) || []).join(' ');
                    });
                    $('tr.e' + id).remove();
                    $('.content').prepend(notify('success', 'Message deleted'));
                }
                else {
                    alert(response.data.error);
                }
            })
            .fail(function () {
                alert("Connect error!");
            })
    });

    function loadEmailList(type, page) {
        if (type != 0 && type != 1)
            type = 0

        if (typeof page != 'undefine' && page < 0)
            page = 1

        $('#email-list').load(appUrl + 'desk/email/list?type=' + type + '&page=' + page);
    }

    $(document).on('click', '.mail-next,.mail-previous', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var page = href.replace('#', '');
        loadEmailList(0, page);
    });

    $(document).on('click', '.cancel_upload', function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        var wrap = $(this).parent();
        var action = $(this).data('action');

        if (!confirm('Are you sure, you want to delete attachment?')) return false;

        if (action == 'compose') {
            $.ajax({
                url: appUrl + 'desk/email/delete/attach',
                type: 'GET',
                dataType: 'json',
                data: {file: url}
            })
                .done(function (response) {
                    if (response.status == 1) {
                        wrap.remove();
                    }
                    else {
                        alert(response.data.error);
                    }
                })
                .fail(function () {
                    alert("Connect error!");
                })
        }
        else {
            wrap.remove();
        }


    });


});
