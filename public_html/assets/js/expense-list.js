$(function () {

    var expenseDatatable = $("#table-expense").DataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "order": [[0, "desc"]],

        //custom processing message
        "oLanguage": {
            "sProcessing": "<i class = 'fa fa-spinner'></i>  Processing..."
        },

        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'accounting/data',
            "type": "POST"
        },
        "columnDefs": [{
            "orderable": false,
            "targets": 4,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "invoice_number"},
            {"data": "billing_date"},
            {"data": "payment_due_date"},
            {"data": "type"}
        ]

    });


    function showActionbtn(row) {
        return '<div class="box-tools"> ' +
        '<a href="#" title="View Payments" data-original-title="View" class="btn btn-box-tool" data-toggle="modal" data-url="' + row.view_url + '" data-target="#fb-modal">' +
        '<i class="fa fa-eye"></i>' +
        '</a>' +
        '<a href="' + appUrl + 'invoice/'+ row.id + '/edit" title="Edit" class="btn btn-box-tool">' +
        '<i class="fa fa-edit"></i>' +
        '</a>' +
        '<button class="btn btn-box-tool btn-delete-expense" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
        '</div>';
    }

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }

    $(function(){
        $("#reg-date-pickers").datepicker({
            "format": "yyyy-mm-dd"
        });
    })

});