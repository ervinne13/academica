@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var classId = '{{$class->id}}';
    var gradedItemId = '{{$gradedItemId}}';
</script>

<script type="text/html" id="student-grades-template">
    <tr class="student-row" data-student-id="<%= student_id %>">        
        <td><%= student_name %></td> 
        <td>
            <input type="text" class="form-control score-field" value="<%= score %>">
        </td>
    </tr>
</script>

<script src="{{ asset ("/js/pages/class-grading/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Class Grading   
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">

                            <div class="form-group">
                                <label>Class Name</label>
                                <input type="text" readonly class="form-control" value="{{ $class->name }}">
                            </div>
                            <div class="form-group">
                                <label>Grading Year</label>
                                <input type="text" readonly class="form-control" value="{{ $class->gradingYear->name }}">
                            </div>
                            <div class="form-group">
                                <label>Level</label>
                                <input type="text" readonly class="form-control" value="{{ $class->level->name }}">
                            </div>

                            <div class="form-group">
                                <label>Teacher</label>
                                <input type="text" readonly class="form-control" value="{{ $class->teacher->first_name }} {{ $class->teacher->last_name }}">
                            </div>  
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" readonly class="form-control" value="{{ $class->teacher->first_name }} {{ $class->subject->name }}">
                            </div>

                        </div>

                        <div class="col-lg-6 col-sm-12" id="students-container">
                            <label class="pull-left">Students Enrolled in the Class</label>                            
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody id="students-tbody"></tbody>
                            </table>
                        </div>   
                    </div>
                </div>
            </div><!-- ./box-body -->
            <div class="box-foot">
                <button id="action-save" class="btn btn-success pull-right">
                    Save
                </button>
            </div>
        </div><!-- /.box -->            
    </div>
</div>

</section><!-- /.content -->
@endsection