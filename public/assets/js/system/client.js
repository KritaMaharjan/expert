$(function () {

    var clientDatatable = $("#table-client").dataTable({
        "dom": '<"top"f>rt<"bottom"lip><"clear">',
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": appUrl + '/system/client/data',
            "type": "POST"
        },

        
        "columnDefs": [{
            "orderable": false,
            "targets": 3,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "id"},
            {"data": "domain"},
            {"data": "email"},
           
        ],

        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            
            $('td:eq(1)', nRow).html('<a href="'+appUrl+'/system/client/'+aData.id+'">' +
               aData.domain + '</a>');
            return nRow;
        },

    });


    $(document).on('click', '.btn-delete-client', function (e) {
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
                url: appUrl + '/client/' + id + '/delete',
                type: 'GET',
                dataType: 'json',
            })
                .done(function (response) {
                    if (response.status === 1) {
                        $('.mainContainer .box-solid').before(notify('success', response.data.message));
                        parentTr.remove();
                    } else {
                        $('.mainContainer .box-solid').before(notify('error', response.data.message));
                        parentTr.show();
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                })
                .fail(function () {
                    alert('something went wrong');
                    parentTr.show();
                })
                .always(function () {
                    doing = false;
                });
        }

    });

    $(document).on('submit', '#client-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formAction = form.attr('action');
        var formData = form.serialize();
        var requestType = form.find('.client-submit').val();

        form.find('.client-submit').val('loading...');
        form.find('.client-submit').attr('disabled', 'disabled');

        form.find('.has-error').removeClass('has-error');
        form.find('label.error').remove();
        form.find('.callout').remove();

        $.ajax({
            url: formAction,
            type: 'POST',
            dataType: 'json',
            data: formData
        })
            .done(function (response) {
                if (response.status === 1) {
                    $('#fb-modal').modal('hide');
                    var tbody = $('.box-body table tbody');
                    if (requestType == 'Add') {
                        $('.mainContainer .box-solid').before(notify('success', 'Product added Successfully'));
                        tbody.prepend(getTemplate(response, false));
                    }
                    else {
                        $('.mainContainer .box-solid').before(notify('success', 'Product updated Successfully'));
                        tbody.find('tr.client-' + response.data.id).html(getTemplate(response, true));
                    }
                    setTimeout(function () {
                        $('.callout').remove()
                    }, 2500);
                }
                else {
                    if ("errors" in response.data) {
                        $.each(response.data.errors, function (id, error) {
                            $('.modal-body #' + id).parent().addClass('has-error')
                            $('.modal-body #' + id).after('<label class="error error-' + id + '">' + error[0] + '<label>');
                        })
                    }

                    if ("error" in response.data) {
                        form.prepend(notify('danger', response.data.error));
                    }

                }
            })
            .fail(function () {
                alert('something went wrong');
            })
            .always(function () {
                form.find('.client-submit').removeAttr('disabled');
                form.find('.client-submit').val(requestType);
            });
    })
})




function showActionbtn(row) {
    console.log(row);
     if(row.status == 1) 
    {
         return '<div class="box-tools">' +
   
    '<a class="block" href="javascript:;" domain="'+row.domain+'" token="" link ="'+appUrl+'/system/block" code="'+row.guid+'">Block</a>' +
    '</div>';

    }
    else
    {
        return '<div class="box-tools">' +
   
    '<a class="block" href="javascript:;" domain="'+row.domain+'" token="" link ="'+appUrl+'/system/block" code="'+row.guid+'">Unblock</a>' + 
    '</div>';
 
    }
   


       
       

}




$(document).on( 'click','.block', function() {
        $this = $(this);
       
        var domain = $this.attr('domain');
         var code = $this.attr('code');
         var url = $this.attr('link');
        $.ajax({
            url: url,
            dataType: 'json',
            data: {'domain':domain,'code':code},
            type: 'get',
            success: function(response) {
              
                if (response.status == 'true')
                {
                   
                    $this.text(response.block);
                    
                }
                
            }
        });


    });


