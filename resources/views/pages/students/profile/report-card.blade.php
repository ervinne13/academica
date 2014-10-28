<?php $totalFinal = 0 ?>

<div class="row">    
    <div class="col-md-8 b-r">

        <h3>Report on Learning Progress and Achievement</h3>

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th colspan="4" class="text-center">Quarter</th>
                    <th></th>                    
                </tr>
                <tr>
                    <th>Learning Area</th>
                    <th class="text-center">1</th>
                    <th class="text-center">2</th>
                    <th class="text-center">3</th>
                    <th class="text-center">4</th>
                    <th class="text-right">Final Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($card["subjects"] AS $subjectGrade)                
                <tr>
                    <td>{{$subjectGrade["name"]}}</td>
                    <td class="text-center">{{$subjectGrade["grades"][1]["transmutedGrade"]}}</td>
                    <td class="text-center">{{$subjectGrade["grades"][2]["transmutedGrade"]}}</td>
                    <td class="text-center">{{$subjectGrade["grades"][3]["transmutedGrade"]}}</td>
                    <td class="text-center">{{$subjectGrade["grades"][4]["transmutedGrade"]}}</td>
                    <td class="text-right">{{$subjectGrade["transmutedGrade"]}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="col-md-4">

        <h3>
            Summary
            <small>
                @if ($card["transmutedGrade"] >= 75)
                Passed                
                @else
                <label class="text-danger">Failed</label>
                @endif
            </small>
        </h3>

        @if ($gradingYear->currently_active_period_id < 4)
        <h5>
            This is the student's partial grade only!            
        </h5>
        <h5>
            The system computed the student's grades based on his performance up to <b>{{$gradingPeriod->name}}</b>
        </h5>
        @endif

        <?php
        if ($card["transmutedGrade"] > 90) {
            $transmutedGradeColor = "bg-green";
        } else if ($card["transmutedGrade"] > 80) {
            $transmutedGradeColor = "bg-aqua-active";
        } else if ($card["transmutedGrade"] > 75) {
            $transmutedGradeColor = "bg-orange";
        } else {
            $transmutedGradeColor = "bg-red";
        }
        ?>

        <div class="small-box {{$transmutedGradeColor}}">
            <div class="inner">
                <h3>{{$card["transmutedGrade"]}}<sup style="font-size: 20px">%</sup></h3>
                <p>Overall Grade</p>
            </div>
            <div class="icon">
                @if ($card["transmutedGrade"] > 90)
                <i class="fa fa-star"></i>
                @elseif($card["transmutedGrade"] > 80)
                <i class="fa fa-thumbs-up"></i>
                @elseif($card["transmutedGrade"] > 75)
                <i class="fa fa-thumbs-up"></i>
                @else
                <i class="fa fa-thumbs-down"></i>
                @endif
            </div>
        </div>

        <div class="small-box bg-aqua-active">
            <div class="inner">
                <h3>21<sup style="font-size: 20px">st</sup></h3>
                <p>Your Current Rank</p>
            </div>
            <div class="icon">
                <i class="fa fa-star"></i>
            </div>
        </div>

        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-book"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Graded Item Completion</span>
                <span class="info-box-number">112 out of 140</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 80%"></div>
                </div>
                <span class="progress-description">
                    80% of the total graded items
                </span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>
</div>