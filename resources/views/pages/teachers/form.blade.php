@extends('layouts.lte-module')

@section('css')
@parent
<link href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('js')
@parent
<script type='text/javascript'>
    var teacherId = '{{$teacher->user_id}}';
    var mode = '{{$mode}}';
</script>

<script type="text/html" id="password-fields-template">
    <div class="form-group">
        <label>Password</label>
        <input type="password" required name="password" class="form-control">
    </div>

    <div class="form-group">
        <label>Repeat Password</label>
        <input type="password" required name="password_repeat" class="form-control">
    </div>
</script>

<script src="{{ asset ("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/image-utils.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/js/pages/teachers/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<?php
$fieldProperty = "required";
if ($mode == "VIEW") {
    $fieldProperty = "readonly";
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Teacher
        <small>
            {{ ($mode == "ADD" ? "Create New" : "Update") }}
        </small>       
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <form class="fields-container">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>username</label>
                                    <input type="text" {{$fieldProperty}} required name="username" class="form-control" value="{{ $teacher->user->username }}">
                                </div>
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" {{$fieldProperty}} name="first_name" class="form-control" value="{{ $teacher->first_name }}">
                                </div>
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" {{$fieldProperty}} name="middle_name" class="form-control" value="{{ $teacher->middle_name }}">
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" {{$fieldProperty}} name="last_name" class="form-control" value="{{ $teacher->last_name }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Birth Date</label>
                                    <input type="text" {{$fieldProperty}} name="birthdate" class="form-control datepicker" value="{{ $teacher->birthdate }}">
                                </div>

                                <div id="password-fields-container">
                                    <button id="action-show-passwords-field" type="button" class="btn btn-link">Change Password</button>
                                </div>
                            </div>                            
                        </div>
                    </form>
                </div><!-- ./box-body -->
                <div class="box-footer">
                    @include('module.parts.actions')
                </div>
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection