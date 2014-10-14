
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
                @foreach($subjects["general"] AS $subject)
                <?php
                $q1         = $faker->numberBetween(74, 98);
                $q2         = $faker->numberBetween(74, 98);
                $q3         = $faker->numberBetween(74, 98);
                $q4         = $faker->numberBetween(74, 98);

                $final = ($q1 + $q2 + $q3 + $q4) / 4;
                $totalFinal += $final;
                ?>
                <tr>
                    <td>{{$subject->name}}</td>
                    <td class="text-center">{{$q1}}</td>
                    <td class="text-center">{{$q2}}</td>
                    <td class="text-center">{{$q3}}</td>
                    <td class="text-center">{{$q4}}</td>
                    <td class="text-right">{{number_format($final, 2)}}</td>
                </tr>
                @endforeach

                <tr>
                    <td class="text-right">MAPEH</td>
                    <td class="text-center">{{$q1}}</td>
                    <td class="text-center">{{$q2}}</td>
                    <td class="text-center">{{$q3}}</td>
                    <td class="text-center">{{$q4}}</td>
                    <td class="text-right">{{number_format($final, 2)}}</td>
                </tr>

                @foreach($subjects["mapeh"] AS $subject)
                <?php
                $q1    = $faker->numberBetween(74, 98);
                $q2    = $faker->numberBetween(74, 98);
                $q3    = $faker->numberBetween(74, 98);
                $q4    = $faker->numberBetween(74, 98);

                $final = ($q1 + $q2 + $q3 + $q4) / 4;
                $totalFinal += $final;
                ?>

                <tr>
                    <td class="text-right">{{$subject->name}}</td>
                    <td class="text-center">{{$q1}}</td>
                    <td class="text-center">{{$q2}}</td>
                    <td class="text-center">{{$q3}}</td>
                    <td class="text-center">{{$q4}}</td>
                    <td class="text-right">{{number_format($final, 2)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="col-md-4">

        <h3>
            Summary
            <small>
                @if ($totalFinal / 13 >= 75)
                Passed                
                @else
                Failed
                @endif
            </small>
        </h3>

        <div class="small-box bg-aqua-active">
            <div class="inner">
                <h3>21<sup style="font-size: 20px">st</sup></h3>
                <p>Your Current Rank</p>
            </div>
            <div class="icon">
                <i class="fa fa-star"></i>
            </div>
        </div>

        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{number_format($totalFinal / 13, 2)}}<sup style="font-size: 20px">%</sup></h3>
                <p>Overall Grade</p>
            </div>
            <div class="icon">
                @if ($totalFinal / 13 > 90)
                <i class="fa fa-star"></i>
                @elseif($totalFinal / 13 > 80)
                <i class="fa fa-thumbs-up"></i>
                @elseif($totalFinal / 13 > 75)
                <i class="fa fa-thumbs-up"></i>
                @else
                <i class="fa fa-thumbs-down"></i>
                @endif
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