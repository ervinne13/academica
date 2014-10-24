@extends('layouts.lte-record-list')

@section('css')
@parent
<style>
    .table-center-th th {
        text-align: center;
    }
</style>
@endsection

@section('js')
@parent
<script src="{{ asset ("/js/pages/class-records/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Class Record
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-6">
            <div id="generate-template-container-box" class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Generate Template / Class Record</h3>                    
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Teacher</label>
                                @if(count($teachers) > 1)
                                <select name="teacher_id" class="form-control">
                                    @foreach($teachers AS $teacher)                                
                                    <option value="{{$teacher->user_id}}">{{$teacher->first_name}} {{$teacher->last_name}}</option>
                                    @endforeach
                                </select>
                                @else
                                <input type="text" style="display:none;" name="teacher_id" class="form-control" value="{{ $teachers[0]->id }}">
                                <input type="text" disabled  class="form-control" value="{{$teachers[0]->first_name}} {{$teachers[0]->last_name}} (You)">                                
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Period</label>
                                <select id="class-record-generation-period" required class="form-control">
                                    @foreach($periods AS $period)                                
                                    <option value="{{$period->id}}">{{$period->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Class</label>
                                <select id="class-record-generation-class-id" required class="form-control">
                                    @foreach($classes AS $class)                                
                                    <option value="{{$class->id}}">{{$class->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- /.col -->                        
                    </div><!-- /.row -->
                </div><!-- ./box-body -->
                <div class="box-footer">
                    <!--<span class="fa fa-upload"></span>--> 
                    <button id="action-generate-class-record" class="btn btn-primary pull-right">Generate & Download</button>
                </div>
            </div><!-- /.box -->            
        </div>

        <div class="col-lg-6">
            <div class="box box-success">
                {!! Form::open(array('url'=>'class-records','method'=>'POST', 'files'=>true)) !!}
                <div class="box-header with-border">
                    <h3 class="box-title">Upload Class Record</h3>                    
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Period</label>
                                <select name="period_id" required class="form-control">
                                    @foreach($periods AS $period)                                
                                    <option value="{{$period->id}}">{{$period->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Class</label>
                                <select name="class_id" required class="form-control">
                                    @foreach($classes AS $class)                                
                                    <option value="{{$class->id}}">{{$class->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Excel File</label>
                                {!! Form::file('file') !!}
                                <p class="errors">{!!$errors->first('file')!!}</p>
                                @if(Session::has('error'))
                                <p class="errors">{!! Session::get('error') !!}</p>
                                @endif
                            </div>
                        </div><!-- /.col -->                        
                    </div><!-- /.row -->
                </div><!-- ./box-body -->
                <div class="box-footer">
                    <!--<span class="fa fa-upload"></span>--> 
                    {!! Form::submit('Upload', array('type' => 'submit', 'class'=>'btn btn-success pull-right')) !!}
                </div>
                {!! Form::close() !!}
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection