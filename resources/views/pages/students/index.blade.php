@extends('layouts.lte-record-list')

@section('js')
@parent
<script src="{{ asset ("/js/pages/students/index.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Students        
    </h1>
</section>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="students-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <a href="/students/create">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </th>       
                                        <th>Student Number</th>
                                        <th>LRN</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Section</th>                                        
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