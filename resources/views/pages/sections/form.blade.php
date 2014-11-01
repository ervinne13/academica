@extends('layouts.lte-module')

@section('js')
@parent
<script type='text/javascript'>
    var sectionId = '{{$section->id}}';
</script>

<script type="text/html" id="assigned-classes">
    <tr class="class-row" data-graded-item-id="<%= id %>">        
        <td><%= name %></td> 
        <td>
            <a href="javascript:void" class="action-delete-class" data-id="<%= id %>">
                <i class="fa fa-times"></i>
            </a>
        </td>
    </tr>
</script>

<script src="{{ asset ("/js/pages/sections/form.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Section
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
                                    <label>Level</label>                        
                                    <select class="form-control" name="level_id" required>
                                        @foreach($levels AS $level) 
                                        <?php $selected = $level->id == $section->level_id ? "selected" : "" ?>
                                        <option value="{{$level->id}}" {{$selected}}>{{$level->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" required name="name" class="form-control" value="{{ $section->name }}">
                                </div>

                                @if($mode == "EDIT")

                                <div class="form-group">
                                    <label>Class</label>
                                    <div class="input-group">
                                        <select id="class-id" hidden class="form-control">
                                            @foreach($selectableClasses AS $class)                                
                                            <option value="{{$class->id}}">{{$class->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-btn">
                                            <button id="action-add-class" class="btn btn-success" type="button">Add >></button>
                                        </span>
                                    </div>
                                </div>

                                @endif

                            </div>

                            @if($mode == "EDIT")
                            <div class="col-lg-6 col-sm-12" id="classes-container">
                                <label class="pull-left">Assigned Classes</label>
                                <a href="javascript:void(0)" id="action-clear-graded-items" class="pull-right">Clear</a>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Class</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="classes-tbody"></tbody>
                                </table>
                            </div>
                            @endif
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