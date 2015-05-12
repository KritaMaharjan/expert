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

    // LINE CHART
    var line = new Morris.Line({
        element: 'line-chart',
        resize: true,
        /*
         xkey: 'y',
         ykeys: ['item1', 'item2', 'item3', 'item4'],
         labels: ['Customers', 'Billing', 'Collection', 'Statistics'],
         */
        data: customerChart,
        // The name of the data record attribute that contains x-values.
        xkey: 'x',
        //xLabelFormat: function (x) { return x.toString(); },
        // A list of names of data record attributes that contain y-values.
        ykeys: ['value1', 'value2', 'value3', 'value4', 'value5'],
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['Total Customers', 'Active Customers', 'Total Emails'],

        //lineColors: ['#fd9d11','#237a7a','#7070a0','#d45127'],
        hideHover: 'auto'
    });