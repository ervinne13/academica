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

    @include('pages.class-records.export-import-content')

</section><!-- /.content -->
@endsection