
/* global grades */

(function () {

    var graphsInitialized = false;
    var labels = [];

    var colors = ['#4286f4', "#7442f4", "#4a2a99", "#715ea0"];

    var shortNames = {
        "Written Works (20%)": "WW (20%)",
        "Performance Tasks (60%)": "PT (60%)",
        "Quarterly Exams (20%)": "QE (20%)"
    };

    $(document).ready(function () {
        initializeEvents();

        //  use first grading's summary
        for (var i in grades[1]["summaryByGradedItemType"]) {
            var name = shortNames[grades[1]["summaryByGradedItemType"][i].name];
            labels.push(name);
        }

    });

    function initializeEvents() {
        $(document).on('shown.bs.tab', 'a[href="#tab-categorical-insights"]', function (e) {

            if (!graphsInitialized) {

                initializeQuarterlyGradeChart();
                for (var i = 1; i <= 4; i++) {
                    initializeByPeriodChart(i);
                }

                graphsInitialized = true;
            }

        });
    }

    function initializeQuarterlyGradeChart() {
        //quarterly-grade

        var labels = [];
        var quarterlyGrades = [];


        for (var i = 1; i <= 4; i++) {
            labels.push("Q" + i);
            quarterlyGrades.push(grades[i].transmutedGrade);
        }

        console.log(quarterlyGrades);

        var data = {
            labels: labels,
            datasets: [
                {
                    data: quarterlyGrades
                }
            ]
        };

        var barChartCanvas = $("#quarterly-grade").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = data;
        barChartData.datasets[0].fillColor = "#00a65a";
        barChartData.datasets[0].strokeColor = "#00a65a";
        barChartData.datasets[0].pointColor = "#00a65a";
        var barChartOptions = {
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to make the chart responsive
            responsive: true,
            maintainAspectRatio: true,
            scaleOverride: true,
            scaleSteps: 8,
            scaleStepWidth: 5,
            scaleStartValue: 60
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);

    }

    function initializeByPeriodChart(periodId) {

        var periodGrades = [];

        for (var i in grades[periodId]["summaryByGradedItemType"]) {
            periodGrades.push(grades[periodId]["summaryByGradedItemType"][i].grade);
        }

        var data = {
            labels: labels,
            datasets: [
                {
                    data: periodGrades
                }
            ]
        };

        var barChartCanvas = $("#chart-period-" + periodId).get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = data;
        barChartData.datasets[0].fillColor = colors[periodId - 1];
        barChartData.datasets[0].strokeColor = colors[periodId - 1];
        barChartData.datasets[0].pointColor = colors[periodId - 1];
        var barChartOptions = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to make the chart responsive
            responsive: true,
            maintainAspectRatio: true
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);

    }

})();
