@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var id = '{{$subject->id}}';
</script>
<script src="{{ asset ("/js/pages/subjects/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Subject
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
                                    <label>Active?</label>                        
                                    <select class="form-control" name="is_active" required>
                                        <option value="1" {{$subject->is_active == 1 ? "selected" : ""}}>Active</option>
                                        <option value="0" {{$subject->is_active == 0 ? "selected" : ""}}>Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Short Name</label>
                                    <input type="text" required name="short_name" class="form-control" value="{{ $subject->short_name }}">
                                </div>

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" required name="name" class="form-control" value="{{ $subject->name }}">
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