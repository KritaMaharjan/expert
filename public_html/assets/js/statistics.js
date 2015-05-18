var FromEndDate = new Date();
var startDate = new Date();
var today = new Date();

$('#date-frm-date-pickers').datepicker({
    format: "yyyy-mm-dd",
    endDate: FromEndDate,
    autoclose: true
})
    .on('changeDate', function(selected){
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#date-to-date-pickers').datepicker('setStartDate', startDate);

    });

$('#date-to-date-pickers')
    .datepicker({
        format: "yyyy-mm-dd",
        startDate: startDate,
        endDate: today,
        autoclose: true
    })
    .on('changeDate', function(selected){
        FromEndDate = new Date(selected.date.valueOf());
        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
        $('#date-frm-date-pickers').datepicker('setEndDate', FromEndDate);
    });

//change graph on click
$(document).on('click', '.graph-heading', function (e) {
    e.preventDefault();
    var $this = $(this);
    var selected = $(this).html();
    var date_from = $('#date-frm-date-pickers').val();
    var date_to = $('#date-to-date-pickers').val();
    var doing = false;
    $('.processing').show();

    if (doing == false) {
        doing = true;

        $.ajax({
            url: appUrl + 'statistics/graph',
            type: 'GET',
            dataType: 'json',
            data : {selected: selected, start_date: date_from, end_date: date_to}
        })
            .done(function (response) {
                if (response.status === 1) {
                    $('.chart-box').html(response.data.template);
                    // make heading active
                    $('.graph-heading').removeClass('active');
                    $this.addClass('active');
                }
            })
            .fail(function () {
                alert('Something went wrong! Please try again later.');
            })
            .always(function () {
                $('.processing').hide();
                doing = false;
            });
    }
});
