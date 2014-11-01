<div class="row">

    <div class="col-md-6">
        Legend:
        <table class="table table-striped">
            <tr>
                <th>Code</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>WW (20%)</td>
                <td>Written Works (20%)</td>
            </tr>
            <tr>
                <td>PT (60%)</td>
                <td>Performance Tasks (60%</td>
            </tr>
            <tr>
                <td>QE (20%)</td>
            <tdQuarterly Exams (20%)</td>
                </tr>
        </table>
    </div>
    <div class="col-md-6">
        <div>
            <h3>Quaterly Grade</h3>

            <div class="chart">
                <canvas id="quarterly-grade" style="height:230px"></canvas>
            </div>

        </div>
    </div>

    <div class="col-md-6">
        <div>
            <h3>First Quarter</h3>

            <div class="chart">
                <canvas id="chart-period-1" style="height:230px"></canvas>
            </div>

        </div>

        <hr>

        <div>
            <h3>Third Quarter</h3>

            <div class="chart">
                <canvas id="chart-period-3" style="height:230px"></canvas>
            </div>

        </div>

    </div>

    <div class="col-md-6">        
        <div>
            <h3>Second Quarter</h3>

            <div class="chart">
                <canvas id="chart-period-2" style="height:230px"></canvas>
            </div>

        </div>

        <hr>

        <div>
            <h3>Finals</h3>

            <div class="chart">
                <canvas id="chart-period-4" style="height:230px"></canvas>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    var grades = {!!json_encode($grades)!!};
</script>