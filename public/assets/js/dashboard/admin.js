$(function () {

    var applicationDatatable = $("#table-application").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + '/system/data',
            "type": "POST"
        },

        "columnDefs": [{
            "orderable": false,
            "targets": 3,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "id"},
            {"data": "client_name"},
            {"data": "type"}
        ]
    });


    function showActionbtn(row) {
        return '<div class="box-tools">' +
            '<a class="block accept-lead" href ="' + appUrl + '/system/application/accept/' + row.id + '">Accept</a> <a class="block decline-lead" href ="' + appUrl + '/system/application/decline/' + row.id + '">Decline</a> <a href="' + appUrl + '/system/application/review/' + row.leadId + '" >View</a> ' +
            '</div>';
    }

    /* Accept application */
    $(document).on('click', '.accept-lead', function (e) {
        e.preventDefault();
        var $this = $(this);
        var parentTr = $this.parent().parent().parent();
        var url = $this.attr('href');
        var doing = false;

        if (!confirm('Are you sure? This action can\'t be undone.')) {
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
                        $('.content').before(notify('success', response.data.message));
                        parentTr.remove();
                    } else {
                        $('.content').before(notify('error', response.data.message));
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

    /* Decline Application */
    $(document).on('click', '.decline-lead', function (e) {
        e.preventDefault();
        var $this = $(this);
        var parentTr = $this.parent().parent().parent();
        var url = $this.attr('href');
        var doing = false;

        if (!confirm('Are you sure? This action can\'t be undone.')) {
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
                        $('.content').before(notify('success', response.data.message));
                        parentTr.remove();
                    } else {
                        $('.content').before(notify('error', response.data.message));
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


});