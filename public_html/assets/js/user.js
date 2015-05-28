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
            "targets": 5,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "fullname"},
            {"data": "created"},
            {"data": "email"},
            {"data": "status"},
            {"data": "days"}
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

    $(document).on('submit', '#subuser-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = form.attr('action');
        
        var formData = new FormData(form[0]);
        formData.append('photo', $('#subuser-form input[type=file]')[0].files[0]);

        $('.modal-body .error').remove();
        form.find('.subuser-submit').val('loading...');
        form.find('.subuser-submit').attr('disabled', 'disabled');

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();
        $('.callout').remove();

        $.ajax({
            url: formAction,
            type: 'POST',
            dataType: 'json',
            data: formData,

            //required for ajax file upload
            processData: false,
            contentType: false
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
                    $('.mainContainer .box-solid').before(notify('success', 'User added Successfully'));
                    var action_html = "<td>"+showActionbtn(response.data)+"</td>";
                    $('#table-user > tbody').prepend("<tr>"+response.template + action_html+"</tr>");
                    $('.modal').modal('hide');

                    //window.location.replace(response.redirect_url);
                } //success
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
        //var formData = form.serialize();

        var formData = new FormData(form[0]);
        formData.append('photo', $('#subuser-form input[type=file]')[0].files[0]);

        $('.modal-body .error').remove();
        form.find('.subuser-submit').val('loading...');
        form.find('.subuser-submit').attr('disabled', 'disabled');

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();
        $('.callout').remove();

        $.ajax({
            url: formAction,
            type: 'POST',
            dataType: 'json',
            data: formData,

            //required for ajax file upload
            processData: false,
            contentType: false
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
                    $('.mainContainer .box-solid').before(notify('success', 'User updated Successfully'));
                    var action_html = "<td>"+showActionbtn(response.data)+"</td>";
                    $('#table-user').find('tr#row-' + response.data.guid).html(response.template + action_html);
                    $('.modal').modal('hide');
                    //window.location.replace(response.redirect_url);
                } //success
                
            })
            .fail(function () {
                alert('Something went wrong! Please try again later');
            })
            .always(function () {
                form.find('.subuser-submit').removeAttr('disabled');
                form.find('.subuser-submit').val('<i class="fa  fa-save"></i> &nbsp;Save');

            });
    });

    $(document).on('click', '.btn-delete-user', function (e) {
        e.preventDefault();
        var $this = $(this);
        var parentTr = $this.parent().parent().parent();
        var delete_url = $this.attr('link');
        var doing = false;

        if (!confirm('Are you sure you want delete? This action will delete data permanently and can\'t be undone.')) {
            return false;
        }

        if (doing == false) {
            doing = true;
            parentTr.hide('slow');

            $.ajax({
                url: delete_url,
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
                    alert('something went wrong');
                })
                .always(function () {
                    doing = false;
                });
        }
    });

    $(document).on('click', '.btn-block-user', function (e) {
        e.preventDefault();
        var $this = $(this);
        var parentTr = $this.parent().parent().parent();
        var parentTd = $this.parent().parent();
        var delete_url = $this.attr('link');
        var doing = false;

        if (!confirm('Are you sure you want to perform the action?')) {
            return false;
        }

        if (doing == false) {
            doing = true;
            $.ajax({
                url: delete_url,
                type: 'GET',
                dataType: 'json'
            })
                .done(function (response) {
                    if (response.success === true) {
                        $('.mainContainer .box-solid').before(notify('success', response.message));
                        var action_html = "<td>"+showActionbtn(response.data)+"</td>";
                        parentTr.html(response.template + action_html);
                        //var action_html = showActionbtn(response.data);
                        //parentTd.html(action_html);
                        //parentTr.remove();
                    } else {
                        $('.mainContainer .box-solid').before(notify('error', response.message));
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                })
                .fail(function () {
                    alert('something went wrong');
                })
                .always(function () {
                    doing = false;
                });
        }
    });

    function notify(type, text) {
        return '<div class="callout alert alert-'+type+'"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' + text + '</div>';
        //return '<div class="callout callout-' + type + '"><p>' + text + '</p></div>';
    }
})