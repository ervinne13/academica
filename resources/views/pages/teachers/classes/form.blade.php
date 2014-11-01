@extends('layouts.lte-module')

@section('css')
@parent
<link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('js')
@parent
<script src="{{ asset ("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}" type="text/javascript"></script>
<script type='text/javascript'>
var teacherId = '{{$teacher->user_id}}';
var classId = '{{$class->id}}';
</script>
<script src="{{ asset ("/js/pages/teachers/classes/form.js") }}" type="text/javascript"></script>

<script type="text/html" id="assigned-graded-items-row-template">
    <tr class="graded-item-row" data-graded-item-id="<%= graded_item_id %>">        
        <td>
            <a href="/classes/{{$class->id}}/grading/<%=graded_item_id%>">
                <%= name %>
            </a>
        </td>
        <td>
            <input type="checkbox" class="is-active-field" <%= is_active == 1 ? 'checked' : '' %>>
        </td>
        <td>
            <input type="text" class="form-control hps-field" value="<%= highest_possible_score %>">
        </td>
        <td>
            <input type="text" class="form-control datetaken-field datepicker_recurring_start" value="<%= datetaken %>">
        </td>  
        <td>
            <a href="javascript:void" class="action-delete-graded-item" data-id="<%= graded_item_id %>">
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

                                <div class="form-group">
                                    <label>Teacher</label>
                                    <select name="teacher_id" required class="form-control"  {{ Auth::user()->role_name == "TEACHER" ? "readonly" : "" }}>
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

                            <div class="col-lg-6" id="graded-items-container">
                                <div class="form-group">
                                    <label>Assign Graded Item</label>                                                                        
                                    <div class="input-group">
                                        <select name="graded_item_id" hidden required class="form-control select2"></select>
                                        <span class="input-group-btn">
                                            <button id="action-add-graded-item" class="btn btn-success" type="button">Add</button>
                                        </span>
                                    </div>
                                </div>

                                <hr>

                                <label class="pull-left">Assigned Graded Items</label>
                                <a href="javascript:void(0)" id="action-clear-graded-items" class="pull-right">Clear</a>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Graded Item</th>
                                            <th>Include In Grading?</th>
                                            <th>HPS</th>
                                            <th>Date Taken</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="assigned-graded-items-tbody"></tbody>
                                </table>

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