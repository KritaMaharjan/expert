<div class="box-body chart-responsive">
    <div class="chart" id="line-chart" style="height: 300px;"></div>
</div>

<script>
    // LINE CHART
    var line = new Morris.Line({
        element: 'line-chart',
        resize: true,
        data: <?php echo json_encode($graph_data); ?>,
        // The name of the data record attribute that contains x-values.
        xkey: 'x',
        //xLabelFormat: function (x) { return x.toString(); },
        // A list of names of data record attributes that contain y-values.
        ykeys: <?php echo json_encode($ykeys); ?>,
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: <?php echo json_encode($labels); ?>,

        //lineColors: ['#fd9d11','#237a7a','#7070a0','#d45127'],
        hideHover: 'auto'
    });
</script>