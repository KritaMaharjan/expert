$(function () {

    var collectionDatatable = $("#table-collection").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "order": [[6, "desc"]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'collection/data',
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
            {"data": "invoice_number"},
            {"data": "customer_name"},
            {"data": "total"},
            {"data": "paid"},
            {"data": "remaining"},
            {"data": "due_date"}
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            $(nRow).attr('id', 'collection-' + aData.id);
            return nRow;
        },

    });


    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }

    function showActionbtn(row) {
        return '<div class="box-tools">' +
        '<a href="#" title="Edit" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' + appUrl + 'collection/' + row.id + '/edit" data-target="#fb-modal">' +
        '<i class="fa fa-edit"></i>' +
        '</a>' +
        '<button class="btn btn-box-tool btn-delete-collection" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
        '</div>';

    }


    function getTemplate(response, type) {
        var html = '<td>' + response.data.id + '</td>' +
            '<td>' + response.data.name + '</td>' +
            '<td>' + response.data.quantity + '</td>' +
            '<td>' + response.data.purchase_cost + '</td>' +
            '<td>' + response.data.selling_price + '</td>' +
            '<td>' + response.data.vat + '</td>' +
            '<td>' + response.data.purchase_date + '</td>' +
            '<td><div class="box-tools">' +
            '<a href="#" title="Edit" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' + response.data.edit_url + '" data-target="#fb-modal">' +
            '<i class="fa fa-edit"></i>' +
            '</a>' +
            '<button class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>' +
            '</div>' +
            '</td>';

        if (type == false)
            return '<tr class="collection-' + response.data.id + '">' + html + '</tr>';
        else
            return html;
    }


});
