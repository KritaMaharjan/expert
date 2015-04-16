$(function () {
    $(document).on('click', '.alert', function () {

        $('.alert').hide();
    });

    $(document).on('click', '.alert-info', function () {

        $('.alert-info').remove();
    });

    $(".dataTable").dataTable({
        //disable sorting in last column
        aoColumnDefs: [
            {
                bSortable: false,
                aTargets: [-1]
            }
        ],
        "dom": '<"top"f>rt<"bottom"lip><"clear">'
    });

    /*$('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue',
        tap: true
    });*/


    var icheck = $('.icheck').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue',
        tap: true
    });

});
