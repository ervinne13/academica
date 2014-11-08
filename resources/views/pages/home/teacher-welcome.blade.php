@extends('layouts.lte')

@section('css')
@parent
<style>
    .table-center-th th {
        text-align: center;
    }
</style>
@endsection

@section('js')
@parent

<script type="text/javascript">
    var teacherId = '{{$teacher->user_id}}';
</script>

<script src="{{ asset ("/js/pages/class-records/form.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/pages/home/teacher-grading.js") }}" type="text/javascript"></script>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Teacher Dashboard        
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">                    
                    <li class="active">
                        <a href="#tab-general" data-toggle="tab">
                            <label class="tab-label text-info">Grading By Graded Item (Web)</label>
                        </a>
                    </li>
                    <li>
                        <a href="#tab-insights" data-toggle="tab">
                            <label class="tab-label text-info">Grading By Excel</label>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-general">
                        @include('pages.home.teacher-tabs.grading-by-graded-item')
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab-insights">
                        @include('pages.home.teacher-tabs.grading-by-excel')
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
        </div>
    </div>

</section><!-- /.content -->

@endsection