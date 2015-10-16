$(function () {

    var applicationDatatable = $("#table-application").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + '/system/application/data',
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
            {"data": "id"},
            {"data": "created_by"},
            {"data": "ex_lead_id"},
            {"data": "status"},
            {"data": "date_created"}
        ]
    });


    function showActionbtn(row) {
        return '<div class="box-tools">' +
            '<a href="' + appUrl + '/system/application/loan/' + row.ex_lead_id + '" class="block">Edit</a> <a href="' + appUrl + '/system/application/review/' + row.ex_lead_id + '">View</a> <br/><a href="' + appUrl + '/system/application/assign/' + row.id + '">Assign Application</a>' +
            '</div>';
    }

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }


});