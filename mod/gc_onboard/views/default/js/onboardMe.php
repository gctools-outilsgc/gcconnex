<?php
/*
* onboardMe.php
*
* Inital Javascript load for onboarding
*/
?>
<script>

        $('#start').on('click', function () {
            elgg.get('ajax/view/profile-steps/stepOne', {

                success: function (output) {

                    $('#onboard').html(output);
                    changeStepProgress(2);
                    currentStep = 1;
                }
            });
        });


        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function toggleEndDate(section, evt) {

            $(evt).closest('.gcconnex-' + section + '-entry').find('.gcconnex-' + section + '-end-year').attr('disabled', evt.checked);
            $(evt).closest('.gcconnex-' + section + '-entry').find('.gcconnex-' + section + '-enddate').attr('disabled', evt.checked);
        }

        $('.quickNav').on('click', function () {
            var ID = $(this).attr('id');


            elgg.get('ajax/view/steps/step' + ID, {
                success: function (output) {

                    $('#step').html(output);


                }
            });
        });

        //change step counter to right step number
        function changeStepProgress(step) {

            elgg.get('ajax/view/page/elements/step_counter', {
                data: {
                    current_step: step,
                    total_steps: 6,
                    class: 'mrgn-tp-md',
                },
                success: function (output) {

                    $('#step-progress').html(output);

                }
            });

        }

</script>
