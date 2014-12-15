
<div class="row">
    <div class="col-md-6">                

        <div>
            <h3>How you rank in your section</h3>

            <div class="small-box bg-aqua-active">
                @if (count($studentsRanked) > 0)
                <?php
                $rank    = 1;
                $ordinal = "";
                foreach ($studentsRanked AS $studentInRank) {
                    if ($studentInRank["student_id"] == $student->id) {
                        $ordinal = $ordinalSuffix[$rank];
                        break;
                    }
                    $rank ++;
                }
                ?>
                <div class="inner">
                    <h3>{{$rank}}<sup style="font-size: 20px">{{$ordinal}}</sup></h3>
                    <p>Your Current Rank</p>
                </div>
                @else
                <div class="inner">
                    <h3>Non Rank</h3>
                    <p>You are not enrolled in a section yet</p>
                </div>
                @endif
                <div class="icon">
                    <i class="fa fa-star"></i>
                </div>
            </div>

        </div>

        <div>
            <h3>Overall Subject Scores Ranked</h3>

            <small>Notice: scores are only partial until the grading year is complete.</small>

            <?php
            $topGrades    = [];
            $medGrades    = [];
            $lowGrades    = [];
            ?>            
            <div class="full-width">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Teacher</th>
                            <th>Subject</th>
                            <th>Actual Grade</th>                            
                            <th>Transmuted Grade</th>                            
                            <th>Rank</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @for ($rank = 1; $rank <= count($card["subjectsRanked"]); $rank ++)
                        <?php $abbreviation = ($rank % 100) >= 11 && ($rank % 100) <= 13 ? $rank . 'th' : $rank . $ordinalSuffix[$rank % 10] ?>
                        <?php $score        = number_format($card["subjectsRanked"][$rank - 1]["transmutedGrade"]) ?>

                        <?php
                        if ($score <= 100 && $score >= 90) {
                            $rowClass = "row-success";
                            array_push($topGrades, $card["subjectsRanked"][$rank - 1]);
                        } else if ($score < 80 && $score >= 75) {
                            $rowClass = "row-warning";
                            array_push($medGrades, $card["subjectsRanked"][$rank - 1]);
                        } else if ($score < 75) {
                            $rowClass = "row-danger";
                            array_push($lowGrades, $card["subjectsRanked"][$rank - 1]);
                        } else {
                            $rowClass = "";
                        }
                        ?>

                        <tr class="{{$rowClass}}">
                            <td>
                                <a href="/teachers/{{$card["subjectsRanked"][$rank - 1]["teacher_id"]}}">
                                    {{$card["subjectsRanked"][$rank - 1]["teacher_name"]}}
                                </a>
                            </td>
                            <td>{{$card["subjectsRanked"][$rank - 1]["name"]}}</td>
                            <td>{{number_format($card["subjectsRanked"][$rank - 1]["initialGrade"], 2)}}</td>
                            <td>{{number_format($card["subjectsRanked"][$rank - 1]["transmutedGrade"], 2)}}</td>
                            <td>{{$abbreviation}}</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <hr>

        <div>
            <h3>Your Monthly Progress</h3>
            <small>Indicates how you perform each month</small>            

            <div class="chart">
                <canvas id="monthly-progress" style="height:250px"></canvas>
            </div>

            <p class="text-bold">Your best performance was in <span id="best-month"></span></p>

        </div>

    </div>

    <div class="col-md-6">
        <div>
            <h3>Quick Analysis</h3>

            @if (count($lowGrades) > 0)
            <?php
            $lowSubjects = [];
            foreach ($lowGrades AS $grade) {
                array_push($lowSubjects, $grade["short_name"]);
            }
            ?>
            <p class="text-red text-bold">IMPORTANT! You need to work on your skills on {{join(', ', $lowSubjects)}}!</p>
            @endif

            @if (count($medGrades) > 0)
            <?php
            $medSubjects = [];
            foreach ($medGrades AS $grade) {
                array_push($medSubjects, $grade["short_name"]);
            }
            ?>            
            <p class="text-bold">Your performance in {{join(', ', $medSubjects)}} needs more work, but well done on passing it.</p>
            @endif

            @if (count($topGrades) > 0)
            <?php
            $topSubjects = [];
            foreach ($topGrades AS $grade) {
                array_push($topSubjects, $grade["short_name"]);
            }
            ?>
            <p>Well done on {{join(', ', $topSubjects)}} keep up the good work!</p>
            @endif                       
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
</div>

<script type="text/javascript">
    var topThreeGrades = {!!json_encode($card["subjectsRanked"])!!}
    ;
            var monthlyGrades = {!!json_encode($monthlyGrades)!!}
    ;
</script>