$(function () {

    var leadDatatable = $("#table-lead").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + '/system/data',
            "type": "POST"
        },

        "columnDefs": [{
            "orderable": false,
            "targets": 6,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "id"},
            {"data": "client_name"},
            {"data": "type"},
            {"data": "amount"},
            {"data": "meeting_time"},
            {"data": "meeting_place"},
        ]
    });


    function showActionbtn(row) {
        return '<div class="box-tools">' +
            '<a class="block accept-lead" href ="' + appUrl + '/system/lead/accept/' + row.id + '">Accept</a> <a href="' + appUrl + '/system/lead/view/' + row.id + '" >View</a> <a class="block" href ="' + appUrl + '/system/lead/log/' + row.id + '">View Logs</a>' +
            '</div>';
    }

    /* Delete lead */
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
                        $('.mainContainer').before(notify('success', response.data.message));
                        parentTr.remove();
                    } else {
                        $('.mainContainer').before(notify('error', response.data.message));
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