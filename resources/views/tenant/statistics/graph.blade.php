<div class="box-body chart-responsive">
    <div class="chart" id="line-chart" style="height: 300px;"></div>
</div>

<script>
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
</script>