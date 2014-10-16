@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var teacherId = '{{$teacher->user_id}}';
    var classId = '{{$class->id}}';
</script>
<script src="{{ asset ("/js/pages/classes/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Class
        <small>
            {{ ($mode == "ADD" ? "Create New" : "Update") }}
        </small>

        @if($mode == "EDIT")
        <small class="pull-right">            
            <a href="/enrollment">Check Enrolled Students</a>            
        </small>
        @endif
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <form class="fields-container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Class Name</label>
                                    <input type="text" required name="name" class="form-control" value="{{ $class->name }}" placeholder="Ex. Grade 3 Math">
                                </div>
                                <div class="form-group">
                                    <label>Grading Year</label>
                                    <select name="grading_year_id" required class="form-control">
                                        @foreach($gradingYears AS $gradingYear)
                                        <?php $selected = $gradingYear->id == $class->grading_year_id ? "selected" : "" ?>
                                        <option value="{{$gradingYear->id}}" {{$selected}}>{{$gradingYear->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Level</label>
                                    <select name="level_id" required class="form-control">
                                        @foreach($levels AS $level)
                                        <?php $selected = $level->id == $class->level_id ? "selected" : "" ?>
                                        <option value="{{$level->id}}" {{$selected}}>{{$level->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Teacher</label>
                                    <select name="teacher_id" required class="form-control">
                                        @foreach($teachers AS $otherTeacher)
                                        <?php
                                        if ($class->teacher_id) {
                                            $selected = $class->teacher_id == $otherTeacher->user_id ? "selected" : "";
                                        } else {
                                            //  If there is no teacher id set, use the current user's teacher id
                                            $selected = $teacher->user_id == $otherTeacher->user_id ? "selected" : "";
                                        }
                                        ?>

                                        <option value="{{$otherTeacher->user_id}}" {{$selected}}>{{$otherTeacher->first_name}} {{$otherTeacher->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>  
                                <div class="form-group">
                                    <label>Subject</label>
                                    <select name="subject_id" required class="form-control">
                                        @foreach($subjects AS $subject)
                                        <?php $selected = $subject->id == $class->subject_id ? "selected" : "" ?>
                                        <option value="{{$subject->id}}" {{$selected}}>({{$subject->short_name}}) {{$subject->name}}</option>
                                        @endforeach
                                    </select>
                                </div>  
                            </div>
                        </div>
                    </form>
                </div><!-- ./box-body -->
                <div class="box-footer">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box-foot">
                                <div class="pull-left">
                                    <!--<button id="action-create-enroll" type="button" class="btn btn-info action-button">Create And Enroll Students</button>-->
                                </div>
                                @if ($mode == "ADD")
                                <div class="pull-right">
                                    <button id="action-create-new" type="button" class="btn btn-success action-button">Create And New</button>
                                    <button id="action-create-close" type="button" class="btn btn-primary action-button">Create And Close</button>
                                </div>
                                @else 
                                <div class="box-foot pull-right">                
                                    <button id="action-update-close" type="button" class="btn btn-primary action-button">Update And Close</button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection