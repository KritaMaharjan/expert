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
    var selected = $(this).html();

});
//chart-box
