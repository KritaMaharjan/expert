$(function () {

    var collectionDatatable = $("#table-collection").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "order": [[6, "desc"]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + 'collection/waiting/data',
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
        }

    });


    function showActionbtn(row) {
        return '<div class="box-tools">' +
        '<a href="#" data-collection="' + row.id + '" title="Add to collection case" class="btn btn-box-tool addToCase">' +
        '<i class="fa fa-plus"></i> Add to collection' +
        '</a>' +
        '</div>';

    }

    $(document).on('click', '.addToCase', function (e) {
        e.preventDefault();
        $this = $(this);
        var id = $(this).data('collection');
        $this.closest('tr').fadeOut('slow');

        $.ajax({
            url: appUrl + 'collection/case/' + id + '/create',
            type: 'GET',
            dataType: 'json'
        }).done(function (response) {
            if (response.status == 1) {
                var alert = notify('success', response.data.message);
                $this.closest('tr').remove();
            }
            else {
                var alert = notify('danger', response.data.message);
                $this.closest('tr').show();
            }
            $('.box-body').prepend(alert);
            setTimeout(function () {
                $('.callout').remove();
            }, 3000);

        }).fail(function () {
            alert('error');
            $this.closest('tr').show();
        });
    });

    function notify(type, text) {
        return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }

});
