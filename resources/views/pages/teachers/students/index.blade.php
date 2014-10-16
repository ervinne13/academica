@extends('layouts.lte-record-list')

@section('js')
@parent
<script src="{{ asset ("/js/pages/teachers/classes/index.js") }}" type="text/javascript"></script>

<script type="text/javascript">
var teacherId = '{{$teacher->user_id}}';
</script>

@endsection

@section('content')

<!-- Content Header (Page header) -->
<section                         class="content-header">
    <h1>
        My Students
        <small>{{Auth::user()->name}}</small>
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Class Name</th>
                                        <th>Year</th>
                                        <th>Level</th>
                                        <th>Subject</th>
                                        <th>Student Name</th>
                                        <th>Student LRN</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div><!-- /.col -->                        
                    </div><!-- /.row -->
                </div><!-- ./box-body -->                
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection