<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{Config::get('app.name')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Bootstrap core CSS -->
        <link href="/vendor/flatify/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom Google Web Font -->
        <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href='/vendor/google-fonts/lato.css' rel='stylesheet' type='text/css'>
        <link href='/vendor/google-fonts/arvo.css' rel='stylesheet' type='text/css'>

        <link href='/bower_components/AdminLTE/dist/css/AdminLTE.min.css' rel='stylesheet' type='text/css'>

        <link href='/css/app.css' rel='stylesheet' type='text/css'>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 50px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="top-right links">
                @if (Route::has('login'))
                <a href="{{ url('/login') }}">Login</a>
                @endif

                <a href="http://www.stfrancis.edu.ph/" class="text-red">Saint Francis of Assisi Website</a>

                <a href="http://www.stfrancis.edu.ph/history.html">About Us</a>
                <a href="https://www.facebook.com/SFACOfficial"><i class="fa fa-facebook fa-2x text-blue"></i></a>
                <a href="https://twitter.com/mysfac"><i class="fa fa-twitter fa-2x text-info"></i></a>
                <a href="https://plus.google.com/104422121833796332859"><i class="fa fa-google-plus fa-2x text-red"></i></a>
            </div>            

            <div class="content">                
                <div class="title">
                    <img src="/static-img/SFACS-logo.png" style="margin: auto;">
                    <br>
                    <!--<span class="text-red">a</span>c<span class="text-red">a</span>demic<span class="text-red">a</span>-->
                    {!!Config::get('app.name_html')!!}
                </div>

                <div class="links m-b-md">
                    <a href="javascript:void(0)">
                        Grading Utility and Student Performance Monitoring for Teachers and Parents
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
