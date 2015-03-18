$(function () {

    var userDatatable = $("#table-user").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "order": [[ 0, "desc" ]],

        //custom processing message
        "oLanguage": {
            "sProcessing": "<i class = 'fa fa-spinner'></i>  Processing..."
        },

        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'user/data',
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
            {"data": "fullname"},
            {"data": "created"},
            {"data": "email"},
            {"data": "status"}

        ]

    });

    function showActionbtn(row) {

        var status = row.raw_status;
        if(status != 3)
            var status_action = '<button data-original-title="Block" id="abc" data-toggle="tooltip" class="btn btn-block-user btn-box-tool" link="'+appUrl+'block/user/'+row.guid+'" ><i class="fa fa-minus-circle"></i></button>';
        else
            var status_action = '<button data-original-title="Unblock" data-toggle="tooltip" class="btn btn-block-user btn-box-tool" link="'+appUrl+'unblock/user/'+row.guid+'" ><i class="fa fa-minus-circle color-red"></i></button>';
        return '<div class="box-tools"> <span data-toggle="modal" data-target="#fb-modal" data-url="'+appUrl+'update/user/'+row.guid+'"> <a data-original-title="Update" data-toggle="tooltip" class="btn btn-box-tool"><i class="fa fa-edit"></i></a> </span> <button data-original-title="Remove" data-toggle="tooltip" class="btn btn-delete-user btn-box-tool" link="'+appUrl+'delete/user/'+row.guid+'" ><i class="fa fa-times"></i></button>'+status_action+'</div>';
    }
})