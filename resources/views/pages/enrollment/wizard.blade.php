@extends('layouts.lte')

@section('js')
<script src="{{ asset ("/js/pages/enrollment/wizard.js") }}" type="text/javascript"></script>
@endsection

@section('content')

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div id="wizard-container" class="box box-body">
                <div data-step="1" class="wizard-step">
                    @include('pages.enrollment.tabs.select-type')
                </div><!-- /.tab-pane -->
                <div data-step="2" class="wizard-step">
                    <form class="new-student-fields-container">
                        @include('pages.students.profile.general')
                    </form>
                </div><!-- /.tab-pane -->
                <div data-step="3" class="wizard-step">
                    <form class="existing-student-fields-container">
                        @include('pages.enrollment.tabs.existing-student')
                    </form>
                </div><!-- /.tab-pane -->
                <div data-step="4" class="wizard-step">
                    step 4
                </div><!-- /.tab-pane -->
            </div><!-- nav-tabs-custom -->
            <div class="box-footer">
                <button id="action-nav-back" class="nav-btn btn btn-default pull-left">
                    << Back
                </button>
                <button id="action-nav-next" class="nav-btn btn btn-success pull-right">
                    Next >>
                </button>
                <button id="action-nav-finish" class="nav-btn btn btn-success pull-right">
                    Finish
                </button>
            </div>
        </div>
    </div>

</section>
@endsection
