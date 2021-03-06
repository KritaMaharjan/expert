var personal_type = 0, support_type = 1;
var sent = 0, inbox = 1;

$( document ).ready(function() {
    $.ajaxSetup({
        beforeSend: function(xhr) {
            $('.email-loader').show();
        },
        complete: function() {
            $('.email-loader').hide();
        }
    });
});

$(function () {

    var requestURL = appUrl + 'desk/email/customer/search';

    function split(val) {
        if (val.length > 0 && val.charAt(val.length - 1) == ';') {
            val = val.substring(0, val.length - 1);
        }

        return val.split(';');
    }

    function extractLast(term) {
        return split(term).pop().trim();
    }

    var cache = {};

    $("#email_to, #email_cc")
        // don't navigate away from the field on tab when selecting an item
        .bind("keydown", function (event) {
            if (event.keyCode === $.ui.keyCode.TAB &&
                $(this).autocomplete("instance").menu.active) {
                event.preventDefault();
            }
        })
        .autocomplete({
            source: function (request, response) {
                var term = extractLast(request.term);
                if (term in cache) {
                    response(cache[term]);
                    return;
                }
                $.getJSON(requestURL, {term: extractLast(request.term)}, function (data, status, xhr) {
                    cache[term] = data;
                    response(data);
                });
            },
            search: function () {
                // custom minLength
                var term = extractLast(this.value);
                if (term.length < 2) {
                    return false;
                }
            },
            focus: function () {
                // prevent value inserted on focus
                return false;
            },
            select: function (event, ui) {
                var terms = split(this.value);
                // remove the current input
                terms.pop();
                // add the selected item
                terms.push(ui.item.value);
                // add placeholder to get the comma-and-space at the end
                terms.push("");
                this.value = terms.join("; ");

                //this.value = (ui.item.label) + " (" + (ui.item.value) + ");";
                return false;
            }
        });


    // SEnd email

    $(document).on('submit', '#compose-form', function (e) {
        e.preventDefault();

        var form = $(this);
        var action = form.attr('action');

        form.find('.btn-email-submit').attr('disabled', 'disabled');

        form.find('.error').remove();
        form.find('.has-error').removeClass('has-error');
        var sending = false;

        if (!sending) {
            sending = true
            $.ajax({
                url: action,
                type: 'POST',
                dataType: 'json',
                data: form.serialize()
            })
                .done(function (response) {

                    if (response.status == '1') {
                        $('#compose-modal').modal('hide');
                        var tbody = $('.table-mailbox');
                        $('.content').prepend(notify('success', 'Message sent'));
                        //tbody.prepend(getTemplate(response.data));
                        setTimeout(function () {
                            $('.callout').remove()
                        }, 4000);
                    }
                    else {
                        if ("errors" in response.data) {
                            $.each(response.data.errors, function (id, error) {
                                form.find('#' + id).parent().parent().addClass('has-error')
                                form.find('#' + id).parent().parent().append('<label class="error error-' + id + '">' + error[0] + '<label>');
                            })
                        }

                        if ("error" in response.data) {
                            form.prepend(notify('danger', response.data.error));
                        }
                    }
                })
                .fail(function () {
                    console.log("Connect Error!");
                })
                .done(function () {
                    sending = false;
                    form.find('.btn-email-submit').removeAttr('disabled');
                })

        }

    });


    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }


    function getTemplate(data) {
        var html = '<tr class="e' + data.id + '">' +
            '<td class="small-col"><i class="fa fa-reply"></i></td>' +
            '<td class="name">' +
            '<a style="display: block" href="#" data-id="' + data.id + '">' +
            data.to +
            '<small class="subject">' + data.subject + '</small>' +
            '</a>' +
            '</td>' +
            '<td class="time"><span>' + data.created_at + '</span></td>' +
            '</tr>';

        return html;
    }

// modal actions
    $(document).on('show.bs.modal', '#compose-modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var action = button.data('action');
        var type = button.data('type');

        //@pooja

        if (action == 'reply') {
            $('.modal-title span').html('Reply to Message');
        } else if (action == 'forward') {
            $('.modal-title span').html('Forward Message');
        }

        var inputType = 0;
        if (type == 'support')
            inputType = 1

        if ($('#type').length > 0) {
            $('#type').val(inputType);
        } else {
            $('#message').before('<input type="hidden" id="type" name="type" value="' + inputType + '"/>');
        }

        var modal = $(this);

        if (typeof action != 'undefined') {
            var id = button.data('id');
            var folder = button.attr('folder');
            $.ajax({
                url: appUrl + 'desk/email/' + id + '/get?folder='+folder,
                type: 'GET',
                dataType: 'json'
            })
                .done(function (response) {
                    var mail = response.data.mail;
                    if (action == 'reply') {
                        $('#email_to').val(mail.to);
                        $('#email_cc').val(mail.cc);
                        $('#subject').val('RE: ' + mail.subject);
                    }
                    else if (action == 'forward')
                        $('#subject').val('FW: ' + mail.subject);

                    $('#message').val(mail.message);
                    $('iframe').contents().find('body').html(mail.message);
                    //    $('#note').val(mail.note);

                    if (typeof(mail.attachments) != "undefined" && mail.attachments !== null && mail.attachments.length > 0) {
                        //$('#filelist').append(getTemplateFields(mail.attachments));
                    }

                })
        }

    });

    $(document).on('hidden.bs.modal', '#compose-modal', function (event) {
        var modal = $(this)
        var form = modal.find('form');
        modal.find('.modal-title span').html('Compose New Message');
        $('#filelist').html('');
        form[0].reset();
        form.find('.error').remove();
        form.find('.has-error').removeClass('has-error');
    })


    function getTemplateFields(data) {
        html = '';
        $.each(data, function (key, item) {
            file = item.file
            html += '<div>' + file + '<input type="hidden" class="attachment" name="attach[]" value="' + file + '"><a href="#" data-action="reply" data-url="' + file + '" class="cancel_upload"><i class="fa fa-times"></i></a></div>';
        });

        return html;
    }

});


// load emails
$(function () {
    loadEmailList(0, 1, 1);

    $('.type').on('click', function () {
        $('.type').removeClass('inbox-active');

        if (!$(this).hasClass('btn-primary')) {

            $(this).addClass('inbox-active');

            var type = $(this).attr('id');
            var folder = $(this).attr('folder');
            if (type == "personal") {
                loadEmailList(personal_type, 1, folder);
            }
            else {
                loadEmailList(support_type, 1, folder);
            }
        }

    });

    // Change Folder
    $('.folder').on('click', function () {

        if (!$(this).parent().hasClass('active')) {
            $('.folder').parent().removeClass('active');

            $(this).parent().addClass('active');

            var type = $(this).attr('id');
            if (type == "sent") {
                $('.type').attr('folder', 0);
                loadEmailList(personal_type, 1, sent);
            }
            else {
                $('.type').attr('folder', 1);
                loadEmailList(personal_type, 1, inbox);
            }
        }

    });

    // Show Mail Details
    $(document).on('click', '.table-mailbox a', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var folder = $(this).attr('folder');

        if (!$('#email-single').hasClass('email-' + id)) {
            $('#email-single').load(appUrl + 'desk/email/' + id + '/show?folder=' + folder);
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
        var folder = $(this).attr('folder');
        $.ajax({
            url: appUrl + 'desk/email/' + id + '/delete?folder=' + folder,
            type: 'GET',
            dataType: 'json'
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
                alert("Connection error!");
            })
    });

    function loadEmailList(type, page, folder) {
        if (type != 0 && type != 1)
            type = 0;

        if (folder != 0 && folder != 1)
            folder = 1; //1 : inbox, 0 : sent

        if (typeof page != 'undefined' && page < 0)
            page = 1;

        $('#email-list').load(appUrl + 'desk/email/list?type=' + type + '&page=' + page + '&folder=' + folder);
    }

    $(document).on('click', '.mail-next,.mail-previous', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var page = href.replace('#', '');
        loadEmailList(0, page, 1);
    });

    $(document).on('click', '.cancel_upload', function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        var wrap = $(this).parent();
        var action = $(this).data('action');

        if (!confirm('Are you sure, you want to delete attachment?')) return false;

        if (action == 'compose') {
            $.ajax({
                url: appUrl + 'file/delete',
                type: 'GET',
                dataType: 'json',
                data: {file: url, folder:'attachment'}
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

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }

});




