<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table class="table table-striped table-center-th">
    <thead>
        @if($mode == "GENERATE")
        <tr>
            <th>ID</th>
            <th>LRN</th>
            <th>student_name</th>

            @foreach($categorizedGradedItems AS $gradedItemTypes) 
            @foreach($gradedItemTypes->gradedItems AS $gradedItem) 
            <th>{{$gradedItem->id}}</th>
            @endforeach
            <th>{{$gradedItemTypes->id}}_total</th>
            <th>{{$gradedItemTypes->id}}_PS</th>
            <th>{{$gradedItemTypes->id}}_WS</th>
            @endforeach
            <th>IG</th>
            <th>TG</th>
            <th>PG</th>
        </tr>
        @endif
        <tr>
            <th></th>
            <th>Class</th>
            <th>{{$class->name}}, {{$period->name}}</th>

            @foreach($categorizedGradedItems AS $gradedItemTypes) 
            <th colspan="{{count($gradedItemTypes->gradedItems) + 3}}">{{$gradedItemTypes->name}}</th>
            @endforeach
            <th>Initial Grade</th>
            <th>Transmuted Grade</th>
        </tr>
        <tr>
            <th></th>
            <th>Teacher</th>
            <th>{{$class->teacher->first_name}} {{$class->teacher->last_name}}</th>
            @foreach($categorizedGradedItems AS $gradedItemTypes) 
            @foreach($gradedItemTypes->gradedItems AS $gradedItem)             

            @if ($gradedItem->is_active)
            <th>{{$gradedItem->short_name}}</th>
            @else
            <td>{{$gradedItem->short_name}}</td>
            @endif

            @endforeach
            <th>Total</th>
            <th>PS</th>
            <th>WS</th>
            @endforeach

            <th></th>                      
            <th></th>                      
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th>Highest Possible Score</th>
            @foreach($categorizedGradedItems AS $gradedItemTypes) 
            <?php $total                   = 0; ?>
            @foreach($gradedItemTypes->gradedItems AS $gradedItem) 

            @if ($gradedItem->is_active)
            <th>{{$gradedItem->highest_possible_score}}</th>
            @else
            <td>{{$gradedItem->highest_possible_score}}</td>
            @endif

            <?php $total += $gradedItem->highest_possible_score ?>
            @endforeach
            <th>{{$total}}</th>
            <th>100</th>
            <th>{{$gradedItemTypes->percentage_value}}</th>
            @endforeach

            <th></th>                      
            <th></th>                      
        </tr>
        <tr>
            <td>ID</td>
            <td>LRN</td>
            <td>Student</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $row                     = 6;
        ?>

        @foreach($students AS $student)
        <?php $wsColumns               = []; ?>

        <tr>
            <td>{{$student->id}}</td>
            <td>{{$student->lrn}}</td>
            <td style="border-right: black solid 2px;">{{$student->last_name}}, {{$student->first_name}} {{$student->middle_name}} </td>

            <?php
            $previousGradedItemCount = 4;
            ?>

            @foreach($categorizedGradedItems AS $gradedItemType)            

            @foreach($gradedItemType->gradedItems AS $gradedItem)
            <td>
                {{array_key_exists($gradedItem->id, $grades[$student->id]) ? $grades[$student->id][$gradedItem->id] : ""}}
            </td>
            @endforeach

            <?php
            $startLetterIndex        = $previousGradedItemCount;
            $endLetterIndex          = $previousGradedItemCount + count($gradedItemType->gradedItems) - 1; //  -1 so the cell with formula won't be counted            

            $startLetter = chr(64 + $startLetterIndex);
            $endLetter   = chr(64 + $endLetterIndex);
            $totalLetter = chr(64 + $endLetterIndex + 1);
            $psLetter    = chr(64 + $endLetterIndex + 2);
            $wsLetter    = chr(64 + $endLetterIndex + 3);

            array_push($wsColumns, "{$wsLetter}{$row}");
            ?>
            <td>
                @if ($mode == "GENERATE")
                =SUM({{$startLetter}}{{$row}}:{{$endLetter}}{{$row}})
                @else

                @if (array_key_exists($gradedItemType->id,$grades[$student->id]["summary"]))
                {{$grades[$student->id]["summary"][$gradedItemType->id]["total"]}}
                @endif

                @endif
            </td>
            <td>
                @if ($mode == "GENERATE")
                <!--3 is the row number of the highest possible score-->
                =({{$totalLetter}}{{$row}} / {{$totalLetter}}4) * 100
                @else
                @if (array_key_exists($gradedItemType->id,$grades[$student->id]["summary"]))
                {{number_format($grades[$student->id]["summary"][$gradedItemType->id]["ps"], 2)}}
                @endif
                @endif
            </td>
            <td style="border-right: black solid 2px;">
                @if ($mode == "GENERATE")
                <!--3 is the row number of the highest possible score-->
                ={{$psLetter}}{{$row}} * ({{$wsLetter}}4 / 100)
                @else
                @if (array_key_exists($gradedItemType->id,$grades[$student->id]["summary"]))
                {{number_format($grades[$student->id]["summary"][$gradedItemType->id]["ws"], 2)}}
                @endif
                @endif
            </td>

            <?php
            //  +3 for next columns            
            $previousGradedItemCount += count($gradedItemType->gradedItems) + 3;
            ?>

            @endforeach

            <td>
                @if ($mode == "GENERATE")
                =SUM({{join(',', $wsColumns)}})
                @else

                @if (array_key_exists("initialGrade",$grades[$student->id]["summary"]))
                {{number_format($grades[$student->id]["summary"]["initialGrade"], 2)}}
                @endif

                @endif
            </td>
            <td>
                @if (array_key_exists("transmutedGrade",$grades[$student->id]["summary"]))
                {{number_format($grades[$student->id]["summary"]["transmutedGrade"], 2)}}
                @endif
            </td>

        </tr>

        <?php $row ++; ?>
        @endforeach
    </tbody>
    @if ($mode != "GENERATE")
    <tfoot>
        <tr></tr>
        <tr>
            <td colspan="10">
                Note: Graded Items in <strong>BOLD</strong> are included in the running partial grade computation while those that are not, are ignored until they are included.
                (Applies only in web mode)
            </td>             
        </tr>
        <tr>
            <td colspan="10">
                Blank Entries: No Grade / Did not pass
            </td>
        </tr>
    </tfoot>
    @endif
</table>