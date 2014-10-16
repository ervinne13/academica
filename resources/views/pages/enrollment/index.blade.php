@extends('layouts.lte-record-list')

@section('js')
@parent
<script src="{{ asset ("/js/pages/enrollment/index.js") }}" type="text/javascript"></script>

<script id="student-selection-template" type="text/html">
    <div class="media">
        <a class="media-left" href="#">
            <img class="media-object" src="<%= image_url %>" alt="Student Image">
        </a>
        <div class="media-body">
            <h4 class="media-heading"><%= first_name %> <%= last_name %></h4>
            <p>LRN Number: <%= lrn_number %></p>
            <p>Student Number: <%= student_number %></p>
        </div>
    </div>
</script>

<script id="student-list-item-template" type="text/html">
    <li class="media">
        <a class="media-left" href="#">
            <img class="media-object" src="<%= image_url %>" alt="Student Image">
        </a>
        <div class="media-body">
            <span class="pull-right">
                <a href="javascript:void(0)" class="action-drop-student" data-id="<%= id %>" data-class-id="<%= class_id %>" data-name="<%= first_name %> <%= last_name %>">
                    <i class="fa fa-times"></i>
                </a>
            </span>
            <h4 class="media-heading"><%= first_name %> <%= last_name %></h4>
            <p>LRN Number: <%= lrn_number %></p>
            <p>Student Number: <%= student_number %></p>
        </div>
    </li>
</script>

@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Enroll Students        
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Students to Enroll</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Teacher</label>
                                @if(count($teachers) > 1)
                                <select name="teacher_id" class="form-control">
                                    @foreach($teachers AS $teacher)                                
                                    <option value="{{$teacher->id}}">{{$teacher->first_name}} {{$teacher->last_name}}</option>
                                    @endforeach
                                </select>
                                @else
                                <input type="text" style="display:none;" name="teacher_id" class="form-control" value="{{ $teachers[0]->id }}">
                                <input type="text" disabled  class="form-control" value="{{$teachers[0]->first_name}} {{$teachers[0]->last_name}} (You)">                                
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Class</label>
                                <select name="class_id" required class="form-control">
                                    @foreach($classes AS $class)                                
                                    <option value="{{$class->id}}">{{$class->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Student</label>
                                <select name="student_id" required class="form-control"></select>
                            </div>
                        </div>
                    </div><!-- /.row -->
                </div><!-- ./box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <button id="action-enroll" type="button" class="btn btn-success action-button">Enroll Selected Student >></button>
                    </div>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-6">
            <div id="students-currently-enrolled-box" class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Students Currently Enrolled </h3>
                    <small id="selected-class-label"></small>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul id="enrolled-students-ul" class="media-list"></ul>
                        </div>
                    </div><!-- /.row -->
                </div><!-- ./box-body -->                
            </div><!-- /.box -->
        </div><!-- /.col -->        
    </div>

</section><!-- /.content -->
@endsection