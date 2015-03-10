$(function () {

    var productDatatable = $("#table-user").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "order": [[ 0, "desc" ]],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + '/user/data',
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

        ],
        

    });

    function showActionbtn(row) {

        var status = row.raw_status;
        if(status != 3)
            var status_action = '<a data-original-title="Block" id="abc" data-toggle="tooltip" class="btn btn-box-tool" href="'+appUrl+'/block/user/'+row.guid+'" ><i class="fa fa-minus-circle"></i></a>';
        else
            var status_action = '<a data-original-title="Unblock" data-toggle="tooltip" class="btn btn-box-tool" href="'+appUrl+'/unblock/user/'+row.guid+'" ><i class="fa fa-minus-circle color-red"></i></a>';
        return '<div class="box-tools pull-right"> <span data-toggle="modal" data-target="#fb-modal" data-url="'+appUrl+'/update/user/'+row.guid+'"> <a data-original-title="Update" data-toggle="tooltip" class="btn btn-box-tool"><i class="fa fa-edit"></i></a> </span> <a data-original-title="Remove" data-toggle="tooltip" class="btn btn-box-tool" href="'+appUrl+'/update/user/'+row.guid+'" ><i class="fa fa-times"></i></a>'+status_action+'</div>';
    }

    $(document).on('submit', '#subuser-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = form.attr('action');
        var formData = form.serialize();

        $('.modal-body .error').remove();
        form.find('.subuser-submit').val('loading...');
        form.find('.subuser-submit').attr('disabled', 'disabled');

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();

        $.ajax({
            url: formAction,
            type: 'POST',
            dataType: 'json',
            data: formData
        })
            .done(function (response) {
                if(response.fail)
                {
                    $.each(response.errors, function( index, value ) {
                        var errorDiv = '.modal-body #'+index;
                        $(errorDiv).closest( ".form-group" ).addClass('has-error');
                        $('.modal-body #'+index).after('<label class="error error-'+index+'">'+value+'<label>');
                    });
                }

                if(response.success) {
                    window.location.replace(response.redirect_url);
                } //success
                response.success
            })
            .fail(function () {
                alert('Something went wrong! Please try again later');
            })
            .always(function () {
                form.find('.subuser-submit').removeAttr('disabled');
                form.find('.subuser-submit').val('<i class="fa  fa-save"></i> &nbsp;Save');

            });
    });

    $(document).on('submit', '#subuser-update-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = form.attr('action');
        var formData = form.serialize();

        $('.modal-body .error').remove();
        form.find('.subuser-submit').val('loading...');
        form.find('.subuser-submit').attr('disabled', 'disabled');

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();

        $.ajax({
            url: formAction,
            type: 'POST',
            dataType: 'json',
            data: formData
        })
            .done(function (response) {
                if(response.fail)
                {
                    $.each(response.errors, function( index, value ) {
                        var errorDiv = '.modal-body #'+index;
                        $(errorDiv).closest( ".form-group" ).addClass('has-error');
                        $('.modal-body #'+index).after('<label class="error error-'+index+'">'+value+'<label>');
                    });
                }

                if(response.success) {
                    window.location.replace(response.redirect_url);
                } //success
                response.success
            })
            .fail(function () {
                alert('Something went wrong! Please try again later');
            })
            .always(function () {
                form.find('.subuser-submit').removeAttr('disabled');
                form.find('.subuser-submit').val('<i class="fa  fa-save"></i> &nbsp;Save');

            });
    });
})