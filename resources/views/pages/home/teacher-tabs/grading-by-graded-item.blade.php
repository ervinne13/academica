<script type="text/html" id="student-grades-template">
    <tr class="student-row" data-student-id="<%= student_id %>">        
        <td><%= student_name %></td> 
        <td>
            <input type="text" class="form-control score-field" name="student_<%= student_id %>_score" value="<%= score %>">
        </td>
    </tr>
</script>

<div class="row">
    <!--    <div class="col-lg-3">
            <div class="form-group">
                <label>Level</label>
                <select id="levels" required class="form-control">
                    <option disabled selected></option>
                    @foreach($levels AS $level)                                
                    <option value="{{$level->id}}">{{$level->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>-->
    <div class="col-lg-3">
        <div class="form-group">
            <label>Subject / Class</label>
            <select id="classes" required class="form-control graded-item-filter-select">
                <option disabled selected></option>
                @foreach($classes AS $class)                                
                <option value="{{$class->id}}">{{$class->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label>Grading Period</label>
            <select id="grading-periods" required class="form-control graded-item-filter-select">
                <option disabled selected></option>
                @foreach($periods AS $period)                                
                <option value="{{$period->id}}">{{$period->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label>Graded Item</label>
            <select id="graded-items" required class="form-control">
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <!--        <label>Press this button to start entering grades</label>
                <button id="action-show-student-grades" class="btn btn-primary">Grade Students</button>-->
    </div>
    <div class="col-lg-6" id="grading-container">

        <table id="student-grades-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Student</th>
                    <th id="student-grades-grade-col-header">Grade</th>
                </tr>
            </thead>
            <tbody id="student-grades-tbody">
                <tr>
                    <td colspan="2">
                        <label style="padding: 32px;">
                            Please select from the filters above and the students under the graded item specified will be displayed here
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>       
    </div>        
    <div class="col-lg-6">
        <label>Graded Item Information:</label>
        <table class="table table-striped">
            <tr>
                <th class="text-right">Name</th>
                <td id="gi-info-name"></td>
            </tr>
            <tr>
                <th class="text-right">Code</th>
                <td id="gi-info-short-name"></td>
            </tr>
            <tr>
                <th class="text-right">Type / Category</th>
                <td id="gi-info-type"></td>
            </tr>
            <tr>
                <th class="text-right">Highest Possible Score (HPS)</th>
                <td id="gi-info-hps"></td>
            </tr>
        </table>
    </div>    
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="pull-right">
            <button id="action-save-grades" class="btn btn-success">Save Changes</button>
            <button id="action-cancel" class="btn btn-default">Cancel / Clear</button>
        </div>
    </div>
</div>