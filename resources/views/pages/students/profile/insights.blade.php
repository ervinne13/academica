<div class="row">
    <div class="col-md-6">                

        <div>
            <h3>How you rank in your class</h3>

            <div class="small-box bg-aqua-active">
                <div class="inner">
                    <h3>21<sup style="font-size: 20px">st</sup></h3>
                    <p>Your Current Rank</p>
                </div>
                <div class="icon">
                    <i class="fa fa-star"></i>
                </div>
            </div>

        </div>

        <div>
            <h3>Overall Subject Scores Ranked</h3>

            <small>Notice: scores are only partial until the grading year is complete.</small>

            <?php $ordinalSuffix = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'); ?>
            <div class="full-width">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Score</th>                            
                            <th>Rank</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @for ($rank = 1; $rank <= count($rankedSubjectScores); $rank ++)
                        <?php $abbreviation  = ($rank % 100) >= 11 && ($rank % 100) <= 13 ? $rank . 'th' : $rank . $ordinalSuffix[$rank % 10] ?>
                        <?php $score         = $rankedSubjectScores[$rank - 1]["percentage"] ?>

                        <?php
                        if ($score <= 100 && $score >= 90) {
                            $rowClass = "row-success";
                        } else if ($score < 80 && $score >= 75) {
                            $rowClass = "row-warning";
                        } else if ($score < 75) {
                            $rowClass = "row-danger";
                        } else {
                            $rowClass = "";
                        }
                        ?>

                        <tr class="{{$rowClass}}">
                            <td>{{$rankedSubjectScores[$rank - 1]["subject"]}}</td>
                            <td>{{$rankedSubjectScores[$rank - 1]["percentage"]}}</td>
                            <td>{{$abbreviation}}</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <hr>

        <div>
            <h3>Top 3 Subjects</h3>

            <div class="full-width">
                <div class="chart" id="top-subjects-chart" style="height: 300px; position: relative;"></div>
                <div id="top-subjects-chart-legend"></div>
            </div>
        </div>

    </div>

    <div class="col-md-6">
        <div>
            <h3>Quick Analysis</h3>
            <p class="text-red text-bold">IMPORTANT! You need to work on your math skills!</p>
            <p class="text-bold">Your performance in Mathematics needs more work, but well done on passing it.</p>
            <p>Well done on Technology and Livelihood Education (TLE), Filipino, and Edukasyong Pantahanan at Pangkabuhayan (EPP), keep up the good work!</p>
        </div>

        <hr>

        <div>
            <h3>Your overall progress in the past 2 months</h3>
            <small>Indicates how you perform each week for the past 2 months</small>            

            <div class="chart">
                <canvas id="past-two-months-progress" style="height:250px"></canvas>
            </div>

            <p class="text-bold">Your best performance was in week number 3 of July, keep that up</p>

        </div>

    </div>
</div>