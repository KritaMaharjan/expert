$(function () {

    var userDatatable = $("#table-bill").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "order": [[ 0, "desc" ]],

        //custom processing message
        "oLanguage": {
            "sProcessing": "<i class = 'fa fa-spinner'></i>  Processing..."
        },

        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'invoice/bill/data',
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
            {"data": "bill_number"},
            {"data": "customer"},
            {"data": "total"},
            {"data": "invoice_date"},
            {"data": "status"}
        ]

    });

    function showActionbtn(row) {
        return '<div class="box-tools"> <span data-toggle="modal" data-target="#fb-modal" data-url="'+appUrl+'update/user/'+row.guid+'"> <a data-original-title="Update" data-toggle="tooltip" class="btn btn-box-tool"><i class="fa fa-edit"></i></a> </span> <button data-original-title="Remove" data-toggle="tooltip" class="btn btn-delete-user btn-box-tool" link="'+appUrl+'delete/user/'+row.guid+'" ><i class="fa fa-times"></i></button></div>';
    }
})