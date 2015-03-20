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

    $(document).on('submit', '#compose-form', function (e) {
        e.preventDefault();

        var form = $(this);
        var action = form.attr('action');

        form.find('.error').remove();
        form.find('.has-error').removeClass('has-error');


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
                    $('.content').prepend(notify('success', 'Message sent successfully'));
                    tbody.prepend(getTemplate(response.data));
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 4000);
                }
                else {
                    if ("errors" in response.data) {
                        $.each(response.data.errors, function (id, error) {
                            $('.modal-body #' + id).parent().parent().addClass('has-error')
                            $('.modal-body #' + id).parent().parent().append('<label class="error error-' + id + '">' + error[0] + '<label>');
                        })
                    }

                    if ("error" in response.data) {
                        form.prepend(notify('danger', response.data.error));
                    }
                }


            })
            .fail(function () {
                console.log("error");
            })
            .always(function () {
                console.log("complete");
            });

    });


    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }


    function getTemplate(data) {
        var html = '<td>' + data.id + '</td>' +
            '<td>' + data.subject + '</td>' +
            '<td>' + data.status + '</td>' +
            '</td>';
        return html;
    }

});


