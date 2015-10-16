$(function () {

    var leadDatatable = $("#table-lead").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + '/system/application/accepted/data',
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
            {"data": "client_name"},
            {"data": "email"},
            {"data": "loan_type"},
            {"data": "assigned"}
        ]
    });


    function showActionbtn(row) {
        var assign = '';
        if(row.isAccepted == false)
            assign = '<a href="' + appUrl + '/system/lender/assign/' + row.id + '">Assign Lender</a>';
        return '<div class="box-tools">' +
            '<a href="' + appUrl + '/system/application/view/' + row.id + '">View</a> <br/>' + assign
            '</div>';
    }

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }

});