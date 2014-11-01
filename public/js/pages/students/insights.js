
/* global monthlyGrades */

(function () {

    var graphsInitialized = false;
    var topSubjectsChart;
    var past2MonthsProgressChart;

    $(document).ready(function () {
        initializeEvents();
    });

    function initializeTopSubjects() {

        var data = [];
        console.log(topThreeGrades);

        for (var i = 0; i < 3; i++) {
            data.push({
                label: topThreeGrades[i].short_name,
                value: topThreeGrades[i].transmutedGrade
            });
        }

        topSubjectsChart = new Morris.Donut({
            element: 'top-subjects-chart',
            resize: true,
            colors: ["#3c8dbc", "#f56954", "#00a65a"],
            data: data,
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
        var areaChartCanvas = $("#monthly-progress").get(0).getContext("2d");
        // This will get the first returned node in the jQuery collection.
        past2MonthsProgressChart = new Chart(areaChartCanvas);

        var labels = [];
        var data = [];
        var bestMonth;
        var bestMonthGrade = 0;

        for (var i in monthlyGrades) {
            labels.push(monthlyGrades[i].month_taken);
            data.push(monthlyGrades[i].transmuted_grade);

            if (bestMonthGrade < monthlyGrades[i].transmuted_grade) {
                bestMonth = monthlyGrades[i].month_taken;
                bestMonthGrade = monthlyGrades[i].transmuted_grade;
            }
        }

        $('#best-month').html(bestMonth);

        var areaChartData = {
            labels: labels,
            datasets: [
                {
                    label: "Digital Goods",
                    fillColor: "rgba(60,141,188,0.9)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: data
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
            responsive: true,
            scaleOverride: true,
            scaleSteps: 8,
            scaleStepWidth: 5,
            scaleStartValue: 60
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
