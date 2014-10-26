
<div class="row">    
    <div class="col-md-3">
        @if ($mode == "VIEW")
        <img src="{{ $student->image_url  ? URL::to('/') . $student->image_url : "" }}" width="250px" height="250px" id="image-preview">        
        @else
        <div id="image-preview-container" class="form-group">
            <label for="input-student-image">Profile Image</label>
            <input type="file" id="input-student-image" name="image">
            <p class="help-block">Ideal size is 250px x 250px</p>

            <img src="{{ $student->image_url  ? URL::to('/') . $student->image_url : "" }}" width="250px" height="250px" id="image-preview">
            <input type="hidden" name="image_url">
        </div>
        @endif
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="form-group col-md-6">
                <label>Learner's Reference Number (LRN)</label>
                <input type="text" required name="lrn" class="form-control" value="{{ $student->lrn }}">
            </div>
            <div class="form-group col-md-6">
                <label>Student Number</label>
                <input type="text" name="student_number" class="form-control" value="{{ $student->student_number }}">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label>First Name</label>
                <input type="text" required name="first_name" class="form-control" value="{{ $student->first_name }}">
            </div>
            <div class="form-group col-md-4">
                <label>Middle Name</label>
                <input type="text" required name="middle_name" class="form-control" value="{{ $student->middle_name }}">
            </div>
            <div class="form-group col-md-4">
                <label>Last Name</label>
                <input type="text" required name="last_name" class="form-control" value="{{ $student->last_name }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label>Birth Date</label>
                <input type="text" name="birthdate" class="form-control datepicker" value="{{ $student->birthdate }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label>Contact Number 1</label>
                <input type="text" name="contact_number_1" class="form-control" value="{{ $student->contact_number_1 }}">
            </div>
            <div class="form-group col-md-4">
                <label>Contact Number 2</label>
                <input type="text" name="contact_number_2" class="form-control" value="{{ $student->contact_number_2 }}">
            </div>
            <div class="form-group col-md-4">
                <label>Landline Number</label>
                <input type="text" name="landline" class="form-control" value="{{ $student->landline }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Address</label>
                <textarea class="form-control" name="address">{{$student->address}}</textarea>
            </div>
        </div>
    </div>
</div>
