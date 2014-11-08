@extends('layouts.lte')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Administrator Page
    </h1>
</section>


<section class="content">

    <div class="row">
        <div class="col-lg-4">

            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Teachers</span>
                    <span class="progress-description">
                        <ul class="list-group">
                            <li><a href="/teachers" style="color: white">Click here to view</a></li>
                            <li><a href="/teachers/create" style="color: white">Click here to add new</a></li>
                        </ul>
                    </span>
                </div><!-- /.info-box-content -->
            </div>

        </div>

        <div class="col-lg-4">

            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-graduation-cap"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Students</span>
                    <span class="progress-description">
                        <ul class="list-group">
                            <li><a href="/students" style="color: white">Click here to view</a></li>
                            <li><a href="/students/create" style="color: white">Click here to add new</a></li>
                        </ul>
                    </span>
                </div><!-- /.info-box-content -->

            </div>
        </div>

        <div class="col-lg-4">

            <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-binoculars"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Viewers / Parents</span>
                    <span class="progress-description">
                        <ul class="list-group">                            
                            <li><a href="/users/create" style="color: white">Click here to add new</a></li>
                        </ul>
                    </span>
                </div><!-- /.info-box-content -->

            </div>
        </div>

        <div class="col-lg-4">

            <div class="info-box bg-fuchsia">
                <span class="info-box-icon"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">All Users</span>
                    <span class="progress-description">                      
                        (Admins, Teachers, Viewers)
                        <ul class="list-group">
                            <li><a href="/users" style="color: white">Click here to view</a></li>
                        </ul>
                    </span>
                </div><!-- /.info-box-content -->

            </div>
        </div>

    </div>

</section><!-- /.content -->

@endsection