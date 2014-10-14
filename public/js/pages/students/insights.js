
(function () {

    var graphsInitialized = false;
    var topSubjectsChart;
    var past2MonthsProgressChart;

    $(document).ready(function () {
        initializeEvents();
    });

    function initializeTopSubjects() {
        topSubjectsChart = new Morris.Donut({
            element: 'top-subjects-chart',
            resize: true,
            colors: ["#3c8dbc", "#f56954", "#00a65a"],
            data: [
//                {label: "Mathematics", value: 92},
//                {label: "Science", value: 89},
//                {label: "English", value: 88}
                {label: "TLE", value: 92},
                {label: "Filipino", value: 91},
                {label: "EPP", value: 90}
            ],
            hideHover: 'auto',
            smooth: true
        });

        topSubjectsChart.options.data.forEach(function (data, i) {
            var legendlabel = $('<span class="legend-text">' + data.label + '</span>');
            var legendItem = $('<span class="legend-box"></span>').css('background-color', topSubjectsChart.options.colors[i]).append(legendlabel);
            $('#top-subjects-chart-legend').append(legendItem);
        });

    }

    function initializePast2MonthsProgress() {
        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $("#past-two-months-progress").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        past2MonthsProgressChart = new Chart(areaChartCanvas);

        var areaChartData = {
            labels: ["June Week 1", "June Week 2", "June Week 3", "June Week 4", "July Week 1", "July Week 2", "July Week 3", "July Week 4"],
            datasets: [
                {
                    label: "Digital Goods",
                    fillColor: "rgba(60,141,188,0.9)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: [74, 72, 78, 81, 84, 86, 89, 87]
                }
            ]
        };

        var areaChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
        };

        past2MonthsProgressChart.Line(areaChartData, areaChartOptions);
    }

    function initializeEvents() {
        $(document).on('shown.bs.tab', 'a[href="#tab-insights"]', function (e) {
//            topSubjectsChart.redraw();

            if (!graphsInitialized) {
                initializeTopSubjects();
                initializePast2MonthsProgress();

                graphsInitialized = true;
            }

        });
    }

})();
