@extends('layouts.lte-record-list')

@section('js')
@parent
<script src="{{ asset ("/js/pages/subjects/index.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Subjects
        <div class="pull-right">
            <a href="/subjects/create" class="btn btn-success btn-sm ">
                <i class="fa fa-plus"></i>
                Add Subject
            </a>
        </div>
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="subjects-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <a href="/subjects/create">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </th>                                        
                                        <th>Active</th>
                                        <th>Default</th>
                                        <th>Name</th>
                                        <th>Short Name</th>
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