var personal_type = 0, support_type = 1;

$(function () {
    var requestURL = appUrl + 'desk/email/customer/search'

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
                        tbody.prepend(getTemplate(response.data));
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

        var inputType = personal_type;
        if (type == 'support')
            inputType = support_type

        if ($('#type').length > 0) {
            $('#type').val(inputType);
        } else {
            $('#message').before('<input type="hidden" id="type" name="type" value="' + inputType + '"/>');
        }

        var modal = $(this);

        if (typeof action != 'undefined') {
            var id = button.data('id');
            $.ajax({
                url: appUrl + 'desk/email/' + id + '/get',
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

                    if (mail.attachments.length > 0) {
                        $('#filelist').append(getTemplateFields(mail.attachments));
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