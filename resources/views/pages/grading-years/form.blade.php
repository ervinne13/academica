@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var id = '{{$gradingYear->id}}';
</script>
<script src="{{ asset ("/js/pages/grading-years/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Grading Year
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
                                    <label>Year</label>                        
                                    <input type="text" required name="year" class="form-control" value="{{ $gradingYear->year }}">
                                </div>                                 

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" required name="name" class="form-control" value="{{ $gradingYear->name }}">
                                </div>

                                <div class="form-group">
                                    <label>
                                        Currently Active Grading Period
                                        <small>*Change this whenever a new grading period starts</small>
                                    </label>                        
                                    <select class="form-control" name="currently_active_period_id" required>
                                        @foreach($gradingPeriods AS $gradingPeriod) 
                                        <?php $selected = $gradingPeriod->id == $gradingYear->level_id ? "selected" : "" ?>
                                        <option value="{{$gradingPeriod->id}}" {{$selected}}>{{$gradingPeriod->name}}</option>
                                        @endforeach
                                    </select>
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