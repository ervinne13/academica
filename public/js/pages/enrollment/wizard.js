
(function () {

    var enrollmentData = {};
    var currentStep = 1;
    var maxSteps = 4;

    $(document).ready(function () {

        initializeEvents();

        showFinish(false);
        enableBack(false);
        enableNext(false);

        showStep(currentStep);

    });

    function initializeEvents() {
        $('#action-nav-new-student').click(function () {
            showStep(2);
            enableBack(true);
            enableNext(true);
            enrollmentData.studentType = "NEW";
        });

        $('#action-nav-existing-student').click(function () {
            showStep(3);
            enableBack(true);
            enableNext(true);
            enrollmentData.studentType = "EXISTING";
        });

        $('#action-nav-back').click(function () {
            currentStep--;

            if (currentStep <= 1) {
                enableBack(false);
                currentStep = 1;
            } else {
                enableBack(true);
            }

            showStep(currentStep);

        });

        $('#action-nav-next').click(function () {
            currentStep++;

            enableBack(true);
            if (currentStep >= maxSteps) {
                enableNext(false);
                currentStep = maxSteps;
            } else {
                enableNext(true);
            }

            showStep(currentStep);

        });

    }

    function showStep(stepNumber) {
        currentStep = stepNumber;
        $('.wizard-step').css('display', 'none');
        $('.wizard-step[data-step=' + stepNumber + ']').css('display', 'block');

        if (stepNumber == 1) {
            //  always disable steps on step 1
            enableBack(false);
            enableNext(false);
        }

    }

    function showFinish(show) {
        if (show) {
            $('#action-nav-finish').css('display', 'inline');
            $('#action-nav-next').css('display', 'none');
        } else {
            $('#action-nav-finish').css('display', 'none');
            $('#action-nav-next').css('display', 'inline');
        }
    }

    function enableBack(enable) {
        if (enable) {
            $('#action-nav-back').removeAttr('disabled');
        } else {
            $('#action-nav-back').attr('disabled', '');
        }
    }

    function enableNext(enable) {
        if (enable) {
            $('#action-nav-next').removeAttr('disabled');
        } else {
            $('#action-nav-next').attr('disabled', '');
        }
    }

})();
