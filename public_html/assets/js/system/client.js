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
            {"data": "username"},
            {"data": "fullname"},
            {"data": "email"},
            {"data": "created_at"}
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {

            $('td:eq(1)', nRow).html('<a href="' + appUrl + '/system/client/' + aData.id + '">' +
            aData.domain + '</a>');
            return nRow;
        }
    });


    function showActionbtn(row) {
        return '<div class="box-tools">' +
            '<a class="block" href ="' + appUrl + '/system/client/edit" code="' + row.id + '">Edit</a> <a href="' + appUrl + '/system/client/delete/' + row.domain + '">Delete</a>' +
            '</div>';
    }

});