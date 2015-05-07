var FromEndDate = new Date();
var startDate = new Date();
var ToEndDate = new Date();
var today = new Date();

ToEndDate.setDate(ToEndDate.getDate()+365);

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