$(function () {

    var leadDatatable = $("#table-lead").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + '/system/lead/data',
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
        if(row.actual_status == 'remove_this') var assign = ' <a class="block" href ="' + appUrl + '/system/lead/assign/' + row.id + '">Assign</a>';
        else var assign = '';
        return '<div class="box-tools">' +
            '<a class="block" href ="' + appUrl + '/system/lead/edit/' + row.id + '">Edit</a> <a class="block" href ="' + appUrl + '/system/lead/view/' + row.id + '">View</a>' + assign +
            '</div>';
    }

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }


});