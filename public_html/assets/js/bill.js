$(function () {

    var billDatatable = $("#table-bill").DataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "order": [[0, "desc"]],

        //custom processing message
        "oLanguage": {
            "sProcessing": "<i class = 'fa fa-spinner'></i>  Processing..."
        },

        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'invoice/'+thisUrl+'/data',
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
        var row = billDatatable.row(tr);

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
        '<li><a href="'+appUrl+'invoice/'+thisUrl+'/'+d.id+'/download">Download</a></li>' +
        '<li><a href="'+appUrl+'invoice/'+thisUrl+'/'+d.id+'/print">Print</a></li>' +
        '</ul>' +
        '</div></td></tr>';
        return $hidden_child;

        return 'Full name: ' + d.name + '<br>' +
        'Salary: ' + d.due_date + '<br>' +
        'The child row can contain any data you wish, including links, images, inner tables etc.';
    }

    function format_bck(d) {
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
        return '<div class="box-tools"> ' +
        '<a href="' + appUrl + 'invoice/'+thisUrl+'/' + row.id + '/edit" title="Edit" class="btn btn-box-tool">' +
        '<i class="fa fa-edit"></i>' +
        '</a>' +
        '<button class="btn btn-box-tool btn-delete-bill" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
        '</div>';
    }

    $(document).on('click', '.btn-delete-bill', function (e) {
        e.preventDefault();
        var $this = $(this);
        var parentTr = $this.parent().parent().parent();
        var id = $this.attr('data-id');
        var doing = false;

        if (!confirm('Are you sure, you want delete? This action will delete data permanently and can\'t be undo')) {
            return false;
        }

        if (id != '' && doing == false) {
            doing = true;
            parentTr.hide('slow');

            $.ajax({
                url: appUrl + 'invoice/'+thisUrl+'/' + id + '/delete',
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