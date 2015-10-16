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
            "targets": 7,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "id"},
            {"data": "client", "orderable": false},
            {"data": "preferred_name", "orderable": false},
            {"data": "ex_clients_id"},
            {"data": "phone_number", "orderable": false},
            {"data": "loan_type", "orderable": false},
            {"data": "meeting_date", "orderable": false},
            {"data": "status"}
        ]
    });


    function showActionbtn(row) {
        var assign = ' <a class="block" href ="' + appUrl + '/system/lead/assign/' + row.id + '">Assign</a>';
        return '<div class="box-tools">' +
            '<a class="block" href ="' + appUrl + '/system/lead/edit/' + row.id + '">Edit</a> <a class="block" href ="' + appUrl + '/system/lead/view/' + row.id + '">View</a>' +
            '</div>';
    }

    /* Delete lead */
    $(document).on('click', '.delete-lead', function (e) {
        e.preventDefault();
        var $this = $(this);
        var parentTr = $this.parent().parent().parent();
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


});