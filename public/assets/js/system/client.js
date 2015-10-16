$(function () {

    var clientDatatable = $("#table-client").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + '/system/client/data',
            "type": "POST"
        },

        "columnDefs": [{
            "orderable": false,
            "targets": 5,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "preferred_name"},
            {"data": "fullname"},
            {"data": "email"},
            {"data": "phone"},
            {"data": "created_at"}
        ]
    });


    function showActionbtn(row) {
        return '<div class="box-tools">' +
            '<a href ="' + appUrl + '/system/client/edit/' + row.id + '"><i class ="fa fa-pencil"></i></a>  &nbsp;&nbsp;<a href="' + appUrl + '/system/client/delete/' + row.id + '" class="delete-client"><i class ="fa fa-trash"></i></a>' +
            '</div>';
    }

    /* Delete client */
    $(document).on('click', '.delete-client', function (e) {
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