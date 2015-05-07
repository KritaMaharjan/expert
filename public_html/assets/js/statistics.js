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
    data: [
        {y: '2011 Q1', item1: 2666, item2: 2666, item3: 15666, item4: 13666},
        {y: '2011 Q2', item1: 2778, item2: 2294, item3: 14666, item4: 12666},
        {y: '2011 Q3', item1: 4912, item2: 1969, item3: 10066, item4: 9666},
        {y: '2011 Q4', item1: 3767, item2: 3597, item3: 13066, item4: 11666},
        {y: '2012 Q1', item1: 6810, item2: 1914, item3: 3566, item4: 12666},
        {y: '2012 Q2', item1: 5670, item2: 4293, item3: 2696, item4: 9666},
        {y: '2012 Q3', item1: 4820, item2: 3795, item3: 1666, item4: 12666},
        {y: '2012 Q4', item1: 15073, item2: 5967, item3: 4666, item4: 11666},
        {y: '2013 Q1', item1: 10687, item2: 4460, item3: 3666, item4: 6666},
        {y: '2013 Q2', item1: 8432, item2: 5713, item3: 2866, item4: 7666}
    ],
    xkey: 'y',
    ykeys: ['item1', 'item2', 'item3', 'item4'],
    labels: ['Customers', 'Billing', 'Collection', 'Statistics'],
    lineColors: ['#fd9d11','#237a7a','#7070a0','#d45127'],
    hideHover: 'auto'
});