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
            "targets": (thisUrl == 'offer')? 4: 5,
            "render": function (data, type, row) {
                return showActionbtn(row);
            }
        }],
        "columns": [
            {"data": "invoice_number"},
            {"data": "customer"},
            {"data": "total"},
            {"data": "invoice_date"},
            (thisUrl == 'bill')? {"data": "status"} : ''
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
            $('.datepicker').datepicker({format: 'yyyy-mm-dd',endDate:new Date(),todayHighlight:true});
            tr.addClass('shown');
        }
    });

    function format(d) {

        var conv = '';
        var payment = '';
        var payment_option = '';

        if(thisUrl == 'offer') {
            conv = '<li><a href="' + appUrl + 'invoice/offer/' + d.id + '/convert">Convert to Bill</a></li>';
        }
        else {
            if(d.raw_status == 3 && d.payment != 1) {
                conv = '<li><a href="' + appUrl + 'invoice/bill/' + d.id + '/credit" class= "credit">Credit</a></li>';
                payment = '<li><a class="link-block" href="#">Register payment</a></li>';
                payment_option = '<div class="payment-info" style="display: none;">' +
                '<form class="payment-form" id="' + d.id + '" method="post" action="">' +
                '<input type="hidden" name="_token" value="' + token + '">' +
                '<div class="form-group"><label> Payment date </label><input name="payment_date" id="payment_date" type="text" class="datepicker form-control"></div>' +
                '<div class="form-group"><label> Amount paid </label><input name="paid_amount" id="paid_amount" type="number" class="form-control"></div>' +
                '<div class="bottom-section clearfix">' +
                '<button class="btn-small btn btn-primary" id="payment-submit">Account as paid</button>' +
                '</form></div>';
            }
        }

        var token = $('meta[name="csrf-token"]').attr('content');

        $hidden_child = '<tr class="temp_tr">' +
        '<td colspan="5"><div class="clearfix">' +
        '<ul class="links-td">' +
        payment +
        '<li><a href="'+appUrl+'invoice/'+thisUrl+'/'+d.id+'/download">Download</a></li>' +
        '<li><a href="'+appUrl+'invoice/'+thisUrl+'/'+d.id+'/print">Print</a></li>'+
        '<li><a href="'+appUrl+'invoice/bill/'+d.id+'/mail" class="send-mail">Send Mail</a></li>'
        + conv +
        '</ul>' +
        payment_option+
        '</div></td></tr>';
        return $hidden_child;

        return 'Full name: ' + d.name + '<br>' +
        'Salary: ' + d.due_date + '<br>' +
        'The child row can contain any data you wish, including links, images, inner tables etc.';
    }

    $(document).on('click', '.credit', function (e) {
        e.preventDefault();

        if (!confirm('Are you sure, you want credit? This action will delete data permanently and can\'t be undo')) {
            return false;
        }

        $this = $(this);
        var parentUl = $this.parent().parent();
        var parent = $this.parent();

        $('.callout').remove();
        $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            dataType: 'json'
        })
            .done(function (response) {
                if (response.success == true || response.status == 1) {
                    parentUl.find('li:first').remove();
                    parent.remove();

                    $('.mainContainer .box-solid').before(notify('success', 'Bill Credited Successfully!'));
                    setTimeout(function () {
                        $('.callout').remove();
                    }, 3000);
                }
                else {
                    $('.mainContainer .box-solid').before(notify('error', 'Something went wrong!'));
                    setTimeout(function () {
                        $('.callout').remove();
                    }, 3000);
                }
            })
            .fail(function () {
                alert('Something went wrong!');
            })

    });

    $(document).on('click', '#payment-submit', function (e) {
        e.preventDefault();
        $('.erroring').remove();
        var form = $(this).parent().parent('.payment-form');
        var token = form.find('input[name="_token"]').val();
        var billId = form.attr('id');
        var formAction = appUrl+"invoice/bill/"+billId+"/payment";
        var formData = form.serialize();

        var requestType = form.find('#payment-submit').val();

        form.find('#payment-submit').val('loading...');
        form.find('#payment-submit').attr('disabled', true);

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
                if (response.success == true || response.status == 1) {
                    $('.error').remove();
                    form.parent().hide();
                    $('.mainContainer .box-solid').before(notify('success', 'Payment Added Successfully!'));
                    setTimeout(function () {
                        $('.callout').remove();
                    }, 3000);

                }
                else {
                    if (response.status == false) {
                        $('.error').remove();
                        $.each(response.data.errors, function (i, v) {
                            // form.closest('form').find('input[name='+i+']').after('<label class="error ">'+v+'</label>');
                            $('#' + i).parent().addClass('has-error');
                            $('#' + i).after('<label class="error erroring error-' + i + '">' + v + '<label>');
                        });
                    }
                }
            })
            .fail(function () {
                alert('Something went wrong!');
            })
            .always(function () {
                form.find('#payment-submit').removeAttr('disabled');
                form.find('#payment-submit').val(requestType);
            });
    });


    $(document).on('click', '.send-mail', function (e) {
        e.preventDefault();
        var $this = $(this);
        var parentTr = $this.closest('.temp_tr').parent();
        var url = $this.attr('href');
        var doing = false;

        if (doing == false) {
            doing = true;
            parentTr.hide('slow');
            parentTr.parent().prev('tr').removeClass('shown');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json'
            })
                .done(function (response) {
                    if (response.status == 1) {
                        $('.mainContainer .box-solid').before(notify('success', response.data.message));
                        parentTr.parent().prev('tr').removeClass('shown');
                        parentTr.hide();
                    } else {
                        parentTr.parent().prev('tr').addClass('shown');
                        parentTr.show('fast');
                        $('.mainContainer .box-solid').before(notify('error', response.data.message));
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

    function showActionbtn(row) {
        return '<div class="box-tools"> ' +
        '<a href="#" title="View Payments" data-original-title="View" class="btn btn-box-tool" data-toggle="modal" data-url="' + row.view_url + '" data-target="#fb-modal">' +
        '<i class="fa fa-eye"></i>' +
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

    $(document).on('click', '.link-block', function(e){
        e.preventDefault();
        $(this).parent().parent().parent().find('.payment-info').toggle();
    });

});