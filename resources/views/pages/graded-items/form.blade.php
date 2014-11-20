@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var id = '{{$gradedItem->id}}';
</script>
<script src="{{ asset ("/js/pages/graded-items/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Graded Item
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>                        
                                    <input type="text" required name="name" class="form-control" value="{{ $gradedItem->name }}" placeholder="Ex. Quiz 1 (Q1)">
                                </div>
                                <div class="form-group">
                                    <label>Code</label>
                                    <label><small>Code or short name will be used to display the graded item in the class record so use something that's about 2 characters</small></label>
                                    <input type="text" name="short_name" class="form-control" value="{{ $gradedItem->short_name }}" placeholder="Ex. (Q1)">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Grading Period</label>                        
                                    <select class="form-control" name="grading_period_id" required>
                                        @foreach($gradingPeriods AS $gradingPeriod) 
                                        <?php $selected = $gradingPeriod->id == $gradedItem->grading_period_id ? "selected" : "" ?>
                                        <option value="{{$gradingPeriod->id}}" {{$selected}}>{{$gradingPeriod->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Type</label>                        
                                    <select class="form-control" name="type_id" required>
                                        @foreach($gradedItemTypes AS $type) 
                                        <?php $selected = $type->id == $gradedItem->type_id ? "selected" : "" ?>
                                        <option value="{{$type->id}}" {{$selected}}>{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Subject</label>                        
                                    <select class="form-control" name="subject_id" required>
                                        @foreach($subjects AS $subject) 
                                        <?php $selected = $subject->id == $gradedItem->subject_id ? "selected" : "" ?>
                                        <option value="{{$subject->id}}" {{$selected}}>{{$subject->name}}</option>
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