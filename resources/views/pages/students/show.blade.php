@extends('layouts.lte')

@section('css')
<!-- Morris charts -->
<link rel="stylesheet" href="/bower_components/AdminLTE/plugins/morris/morris.css">
@endsection

@section('js')
<script src="/bower_components/AdminLTE/plugins/morris/morris.min.js"></script>
<script src="/bower_components/AdminLTE/plugins/morris/raphael-min.js"></script>
<script src="/bower_components/AdminLTE/plugins/chartjs/Chart.min.js"></script>
<script src="/js/pages/students/insights.js"></script>    
@endsection

@section('content')

<!-- Content Header (Page header) -->
<!--<section class="content-header">
    <h1>
        Student Information
    </h1>
</section>-->

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="pull-left header"><i class="fa fa-th"></i> {{$student->full_name}}</li>
                    <li class="active"><a href="#tab-general" data-toggle="tab">Profile / General Information</a></li>
                    <li><a href="#tab-insights" data-toggle="tab">Performance Insights</a></li>
                    <li><a href="#tab-report-card" data-toggle="tab">Report Card</a></li>
<!--                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Actions <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Enroll in one of my classes</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Generate a Printable Report Card (PDF)</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Generate Full Performance Report (Excel)</a></li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="#">
                                    <span class="text-red">Mark student as inactive</span>
                                </a>
                            </li>
                        </ul>
                    </li>                    -->
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-general">
                        @include('pages.students.profile.general')
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab-insights">
                        @include('pages.students.profile.insights')
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab-report-card">
                        @include('pages.students.profile.report-card')
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
        </div>
    </div>

</section><!-- /.content -->
@endsection
