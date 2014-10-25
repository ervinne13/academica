@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var id = '{{$user->id}}';    
</script>

<script src="{{ asset ("/js/pages/users/change-password.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Change Password        
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

<!--                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input type="password" required name="password" class="form-control" >
                                </div>-->

                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" required name="new_password" class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label>Repeat New Password</label>
                                    <input type="password" required name="new_password_repeat" class="form-control" >
                                </div>
                            </div>                            
                        </div>
                    </form>
                </div><!-- ./box-body -->
                <div class="box-footer">
                    <button id="action-change-password" class="btn btn-success">
                        <i class="fa fa-lock"></i> Change Password
                    </button>
                </div>
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection