<?php
$totalFinal    = 0;
$hasMapeh      = FALSE;
$mapehSubjects = [
    "Music",
    "Arts",
    "PE",
    "Health"
];
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>{{env("APP_TITLE_TEXT")}}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!--Favicon-->
        <link rel="shortcut icon" href="{{ asset('favicon/favicon-graduation-cap.ico') }}">

        <!-- Bootstrap 3.3.2 -->
        <link href="{{ asset("/bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="{{ asset("/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css" />

        <!-- Ionicons -->
        <!--<link href="/ionicons/ionicons.min.css" rel="stylesheet" type="text/css" />-->

        <!--Other Element / View Styles-->
        <link href="{{ asset("/bower_components/sweetalert2/dist/sweetalert2.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/bower_components/AdminLTE/plugins/select2/select2.min.css")}}" rel="stylesheet" type="text/css" />

        <!-- Theme style -->
        <link href="{{ asset("/bower_components/AdminLTE/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />

        <!--Skin: Blue-->
        <!--<link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />-->
        <!--<link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-green-light.min.css")}}" rel="stylesheet" type="text/css" />-->
        <link href="{{ asset("/bower_components/AdminLTE/dist/css/skins/skin-red-light.min.css")}}" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->        

        <link href="{{ asset("/css/app.css")}}" rel="stylesheet" type="text/css" />

        <style>

            html * {
                font-size: 1em !important;
                color: #000 !important;
                font-family: Arial !important;
            }

            .rotate {
                font-size: 11px;
                line-height: 0px;                
                /* FF3.5+ */
                -moz-transform: rotate(-90.0deg);
                /* Opera 10.5 */
                -o-transform: rotate(-90.0deg);
                /* Saf3.1+, Chrome */
                -webkit-transform: rotate(-90.0deg);
                /* IE8 */
                -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
                /* Standard */
                transform: rotate(-90.0deg);

            }
            
            #guidlines-for-rating-table tr th,td {
                padding: 4px;
            }
        </style>

        <meta name="_token" content="{{csrf_token()}}">        
    </head>
    <body>
        <div class="wrapper pad">
            <div class="row">
                <div class="col-xs-6">
                    <h4 style="text-align: center">Periodic Rating</h4>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>                    
                            <tr>
                                <th>Learning Area</th>
                                <th class="text-center">1</th>
                                <th class="text-center">2</th>
                                <th class="text-center">3</th>
                                <th class="text-center">4</th>
                                <th class="text-right">Final Grade</th>
                                <th style="min-width: 150px">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($card["subjects"] AS $subjectGrade)
                            @if (!in_array($subjectGrade["short_name"], $mapehSubjects))
                            <tr>
                                <td>{{$subjectGrade["name"]}}</td>
                                <td class="text-center">{{$subjectGrade["grades"][1]["transmutedGrade"]}}</td>
                                <td class="text-center">{{$subjectGrade["grades"][2]["transmutedGrade"]}}</td>
                                <td class="text-center">{{$subjectGrade["grades"][3]["transmutedGrade"]}}</td>
                                <td class="text-center">{{$subjectGrade["grades"][4]["transmutedGrade"]}}</td>
                                <td class="text-right">{{$subjectGrade["transmutedGrade"]}}</td>
                                <td></td>
                            </tr>
                            @else
                            <?php $hasMapeh      = TRUE ?>
                            @endif
                            @endforeach

                            @if ($hasMapeh)
                            <tr>
                                <th style="text-align: right;">MAPEH</th>
                                <td class="text-center">{{$card["mapeh"][1]["transmutedGrade"]}}</td>
                                <td class="text-center">{{$card["mapeh"][2]["transmutedGrade"]}}</td>
                                <td class="text-center">{{$card["mapeh"][3]["transmutedGrade"]}}</td>
                                <td class="text-center">{{$card["mapeh"][4]["transmutedGrade"]}}</td>
                                <td class="text-right">{{$card["mapeh"]["transmutedGrade"]}}</td>
                                <td></td>
                            </tr>

                            @foreach($card["subjects"] AS $subjectGrade)
                            @if (in_array($subjectGrade["short_name"], $mapehSubjects))
                            <tr>
                                <td style="text-align: right;">{{$subjectGrade["name"]}}</td>
                                <td class="text-center">{{$subjectGrade["grades"][1]["transmutedGrade"]}}</td>
                                <td class="text-center">{{$subjectGrade["grades"][2]["transmutedGrade"]}}</td>
                                <td class="text-center">{{$subjectGrade["grades"][3]["transmutedGrade"]}}</td>
                                <td class="text-center">{{$subjectGrade["grades"][4]["transmutedGrade"]}}</td>
                                <td class="text-right">{{$subjectGrade["transmutedGrade"]}}</td>
                                <td></td>
                            </tr>                
                            @endif
                            @endforeach

                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: right;">General Ave.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>                                
                                <td class="text-right">{{$card["transmutedGrade"]}}</td>
                                <td></td>
                            </tr>   
                        </tfoot>
                    </table>

                    <hr>

                    <label>Legend</label>

                    <table class="table table-borderless">
                        <tr>
                            <td><b>O</b> - Outstanding</td>
                            <td><b>90% and above</b></td>
                        </tr>
                        <tr>
                            <td><b>VS</b> - Very Satisfactory</td>
                            <td><b>85% - 89%</b></td>
                        </tr>
                        <tr>
                            <td><b>S</b> - Satisfactory</td>
                            <td><b>80% - 84%</b></td>
                        </tr>
                        <tr>
                            <td><b>FS</b> - Satisfactory</td>
                            <td><b>75% - 79%</b></td>
                        </tr>
                        <tr>
                            <td><b>DME</b> - Did not meet the expectations</td>
                            <td><b>74% and below</b></td>
                        </tr>
                    </table>

                    <hr>
                    <table class="table-bordered attendance-table">
                        <tr>
                            <th colspan="14" style="text-align: center">Attendance Record</th>
                        </tr>
                        <tr style="height: 60px;">
                            <td></td>
                            <td class="rotate">January</td>
                            <td class="rotate">February</td>
                            <td class="rotate">March</td>
                            <td class="rotate">April</td>
                            <td class="rotate">May</td>
                            <td class="rotate">June</td>
                            <td class="rotate">July</td>
                            <td class="rotate">August</td>
                            <td class="rotate">September</td>
                            <td class="rotate">October</td>
                            <td class="rotate">November</td>
                            <td class="rotate">December</td>
                            <td class="rotate">Total</td>
                        </tr>
                        <tr style="height: 20px;">
                            <td>No. of school days</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="height: 20px;">
                            <td>No. of school days present</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>

                </div>

                <div class="col-xs-6">
                    <h4 style="text-align: center">Character and CORE VALUES</h4>
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <th colspan="2" style="text-align: center">Traits</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                        </tr>
                        <tr><td>1</td><td>Honesty and Truthfulness</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>2</td><td>Courtesy and Respect</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>3</td><td>Helfulness and Cooperation</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>4</td><td>Resourcefulness and Creativity</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>5</td><td>Considerate - Fair and Just</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>6</td><td>Sportsmanship</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>7</td><td>Obedience</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>8</td><td>Self-Reliance and Creativity</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>9</td><td>Industry and Diligence</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>10</td><td>Cleanliness and Orderliness</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>11</td><td>Promptness and Punctuality</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>12</td><td>Love of God</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>13</td><td>Love of Country</td><td></td><td></td><td></td><td></td></tr>
                        <tr><td>13</td><td>Perseverance</td><td></td><td></td><td></td><td></td></tr>
                    </table>

                    <table id="guidlines-for-rating-table" style="border: 1px solid black; margin: auto;">
                        <tr><th>Guidlines for Rating</th></tr>
                        <tr> </tr>
                        <tr><td><b>AO</b> Always Observed</td></tr>
                        <tr><td><b>SO</b> Sometimes Observed</td></tr>
                        <tr><td><b>RO</b> Rarely Observed</td></tr>
                        <tr><td><b>NO</b> Not Observed</td></tr>                        
                    </table>

                </div>

            </div>
        </div>

        <!-- jQuery -->
        <script src="{{ asset ("/bower_components/AdminLTE/plugins/jQuery/jQuery-2.2.3.min.js") }}"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="{{ asset ("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset ("/bower_components/AdminLTE/dist/js/app.min.js") }}" type="text/javascript"></script>

        <script src="{{ asset ("/bower_components/sweetalert2/dist/sweetalert2.min.js") }}" type="text/javascript"></script>
        <script src="{{ asset ("/bower_components/AdminLTE/plugins/select2/select2.min.js") }}" type="text/javascript"></script>

        <script src="{{ asset ("/vendor/underscore/underscore.js") }}" type="text/javascript"></script>

        <script src="{{ asset ("/js/utilities.js") }}" type="text/javascript"></script>
        <script src="{{ asset ("/js/globals.js") }}" type="text/javascript"></script>

        <!-- Optionally, you can add Slimscroll and FastClick plugins.
              Both of these plugins are recommended to enhance the
              user experience -->

        <script type="text/javascript">
var baseURL = '{{ URL::to("/") }}';
var _token = $('meta[name="_token"]').attr('content');
$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
});

$(document).ready(function () {
    $('.rotate').css('height', $('.rotate').width());
    $('.rotate').css('width', '5px');

});

        </script>

    </body>
</html>