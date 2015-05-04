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
        '<a href="#" data-collection="' + row.id + '" title="Add to collection case" class="btn btn-box-tool addToCase">' +
        '<i class="fa fa-plus"></i>' +
        '</a>' +
        '</div>';

    }

    $(document).on('click', '.addToCase', function (e) {
        e.preventDefault();
        var id = $(this).data('collection');

        $.ajax({
            url: appUrl + 'collection/case/' + id + '/create',
            type: 'GET',
            dataType: 'json',
        }).done(function (data) {
            alert(data);
        });
    })

});
