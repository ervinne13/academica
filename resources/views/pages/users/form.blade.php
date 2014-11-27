@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var id = '{{$user->id}}';
    var mode = '{{$mode}}';
</script>

<script type="text/html" id="password-fields-template">
    <div class="form-group">
        <label>Password</label>
        <input type="password" required name="password" class="form-control" placeholder="let the parent / student / user type">
    </div>

    <div class="form-group">
        <label>Repeat Password</label>
        <input type="password" required name="password_repeat" class="form-control" placeholder="let the parent / student / user type">
    </div>
</script>

<script src="{{ asset ("/js/pages/users/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @if ($user->role_name == "VIEWER")
        Parent / Viewer
        @elseif ($user->role_name == "TEACHER")
        Teacher Account
        @else
        Administrator
        @endif
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
                                    <input type="text" required name="username" class="form-control" value="{{ $user->username }}">
                                </div>

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" required name="name" class="form-control" value="{{ $user->name }}">
                                </div>

                                <div id="password-fields-container">
                                    <button id="action-show-passwords-field" type="button" class="btn btn-link">Change Password</button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                @if ($user->role_name == "VIEWER")
                                <div class="form-group">
                                    <label>Accessible Links</label>
                                    <br>
                                    <small>
                                        Separate each link with comma (,) and remove base URL (ex. academica.sytes.net:9017)
                                        <br>
                                        Use format link name:link url
                                    </small>
                                    <textarea class="form-control" name="links" rows="5" placeholder="Ex. Bridgette Dela Cruz:/students/13,Anya Dela Cruz:/students/14">{{$user->getFormattedLinks()}}</textarea>
                                </div>
                                @endif
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