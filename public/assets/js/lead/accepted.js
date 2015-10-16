$(function () {

    var leadDatatable = $("#table-lead").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + '/system/lead/accepted/data',
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
            {"data": "email"},
            {"data": "loan_type"},
            {"data": "meeting_datetime"},
            {"data": "meeting_place"}
        ]
    });


    function showActionbtn(row) {
        return '<div class="box-tools">' +
            '<a href="' + appUrl + '/system/application/loan/' + row.id + '" class="block">Prepare Application</a> <a href="' + appUrl + '/system/lead/view/' + row.id + '">View</a> <br/><a href="' + appUrl + '/system/lead/attachment/' + row.id + '">Interview Notes</a> <br/>' +
            '</div>';
    }

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }


});