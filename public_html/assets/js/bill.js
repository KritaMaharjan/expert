$(function () {

    var userDatatable = $("#table-bill").DataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "order": [[0, "desc"]],

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
            {"data": "invoice_number"},
            {"data": "customer"},
            {"data": "total"},
            {"data": "invoice_date"},
            {"data": "status"}
        ]

    });

    $('#table-bill tbody').on('click', '.link', function (event) {
        event.preventDefault();
        var tr = $(this).closest('tr');
        var row = userDatatable.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    function format(d) {
        $hidden_child = '<tr class="temp_tr">' +
        '<td colspan="5"><div class="clearfix">' +
        '<ul class="links-td">' +
        '<li><a class="link-block" href="#">Register payment</a></li>' +
        '<li><a href="#">Last ned and print</a></li>' +
        '<li><a href="#">Resend</a></li>' +
        '<li><a class="red" href="#">Credit</a></li>' +
        '</ul>' +
        '<div class="payment-info" style="display: block;">' +
        '<form>' +
        '<label> Payment date <input type="text"></label>' +
        '<label> Amount paid <input type="text"></label>' +
        '<div class="bottom-section clearfix">' +
        '<a class="btn-small btn btn-primary" href="#">Account as paid</a>' +
        '<a class="abort btn btn-danger" href="#">Abort</a></div>' +
        '</form></div></div></td></tr>';
        return $hidden_child;

        return 'Full name: ' + d.name + '<br>' +
        'Salary: ' + d.due_date + '<br>' +
        'The child row can contain any data you wish, including links, images, inner tables etc.';
    }

    function showActionbtn(row) {
        return '<div class="box-tools"> <span data-toggle="modal" data-target="#fb-modal" data-url="' + appUrl + 'update/user/' + row.guid + '"> <a data-original-title="Update" data-toggle="tooltip" class="btn btn-box-tool"><i class="fa fa-edit"></i></a> </span> <button data-original-title="Remove" data-toggle="tooltip" class="btn btn-delete-user btn-box-tool" link="' + appUrl + 'delete/user/' + row.guid + '" ><i class="fa fa-times"></i></button></div>';
    }
})