@extends('layouts.lte-record-list')

@section('js')
@parent
<script src="{{ asset ("/js/pages/enrollment/enroll-by-student.js") }}" type="text/javascript"></script>

<script id="student-selection-template" type="text/html">
    <div class="media">
        <a class="media-left" href="#">
            <img style="width: 75px; height: 75px;" class="media-object" src="<%= image_url %>" alt="Student Image">
        </a>
        <div class="media-body">
            <h4 class="media-heading"><%= first_name %> <%= last_name %></h4>
            <p>LRN: <%= lrn %></p>
        </div>
    </div>
</script>

<script type="text/html" id="assigned-classes">
    <tr class="class-row" data-graded-item-id="<%= id %>">        
        <td><%= name %></td> 
        <td>
            <a href="javascript:void" class="action-delete-class" data-id="<%= id %>">
                <i class="fa fa-times"></i>
            </a>
        </td>
    </tr>
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
            <div id="students-to-enroll-box" class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Students to Enroll</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Student</label>
                                <select name="student_id" required class="form-control"></select>
                            </div>

                            <div class="form-group">                                
                                <a href="students/create" class="btn btn-link">
                                    Not yet existing? Register the student by clicking here.
                                    <br>
                                    After registration, go back here @ + Enroll Student link
                                </a>
                            </div>

                        </div>
                    </div><!-- /.row -->
                </div><!-- ./box-body -->                
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-6">
            <div id="students-currently-enrolled-box" class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Select Section / Level</h3>
                    <small id="selected-class-label"></small>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Section</label>
                                <select name="section_id" required class="form-control">
                                    <option disabled selected></option>
                                    @foreach($sections AS $section)
                                    <option value="{{$section->id}}" data-classes='{!! htmlspecialchars(json_encode($section->classes)) !!}'>
                                        ({{$section->level->name}}) {{$section->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="pull-left">Classes To Enroll</label>                                
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Class</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="classes-tbody"></tbody>
                                </table>
                            </div>

                        </div>
                    </div><!-- /.row -->
                </div><!-- ./box-body -->                
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-12">
            <div class="pull-right">
                <button id="action-enroll" type="button" class="btn btn-success action-button">Enroll</button>
            </div>
        </div>
    </div>

</section><!-- /.content -->
@endsection