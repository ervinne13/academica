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
<script src="{{ asset ("/js/pages/class-records/index.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header"></section>

<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Class Record 
                        <small>
                            {{$period->name}}
                        </small>
                    </h3>
                    <div class="box-tools pull-right">                        
                        <div class="btn-group open">
                            <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-link"></i> {{$period->name}}
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                @foreach($periods AS $selectablePeriod)
                                <li><a href="/period/{{$selectablePeriod->id}}/class/{{$class->id}}/class-record">{{$selectablePeriod->name}}</a></li>
                                @endforeach

                                <li class="divider"></li>
                                <li>
                                    <a href="/period/{{$period->id}}/class/{{$class->id}}/class-record/generate" target="_blank">
                                        Generate Excel
                                    </a>
                                </li>
                            </ul>
                        </div>                        
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="class-record-container" class="table-responsive" style="height: 480px;">
                                @include('excel.class-record')
                            </div>
                        </div><!-- /.col -->                        
                    </div><!-- /.row -->
                </div><!-- ./box-body -->                
            </div><!-- /.box -->            
        </div>
    </div>

</section><!-- /.content -->
@endsection