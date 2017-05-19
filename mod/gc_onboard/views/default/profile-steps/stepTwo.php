<?php
/*
 * stepTwo.php - Profile
 *
 * Second step of profile module. Asks for user's education.
 */
?>

<h2>
    <?php echo elgg_echo('onboard:profile:two:title'); echo elgg_view('page/elements/step_counter', array('current_step'=>3, 'total_steps'=>6, 'class' => 'mrgn-tp-md wb-inv'));?>
</h2>

<div class="onboarding-cta-holder">
    <?php echo elgg_echo('onboard:profile:edu:why');?>

</div>

<?php
    $user = elgg_get_logged_in_user_entity();
    echo '<div class="clearfix mrgn-tp-md mrgn-bttm-md">'.elgg_view('onboard/input/education').'</div>';
?>
    <div class="mrgn-bttm-md pull-right">

    <button type="button" id="skip" class="mrgn-lft-sm btn btn-default">
        <?php echo elgg_echo('onboard:skip'); ?>
    </button>

    <button type="button" id="onboard-edu" class="btn btn-primary">
        <?php echo elgg_echo('onboard:welcome:next'); ?>
    </button>

    </div>

<script>

    //add education
    $('#onboard-edu').on('click', function () {

        elgg.action('onboard/update-profile', {
            data: {
                section: 'edu',
                eguid: $('.gcconnex-education-entry').data('guid'),
                school: $('#education-new').val(),
                degree: $('#degree-new').val(),
                field: $('#fieldofstudy-new').val(),
                startdate: $('#startdate-new').val(),
                startyear: $('#start-year-new').val(),
                enddate: $('#enddate-new').val(),
                endyear: $('#end-year-new').val(),
                ongoing: $('.gcconnex-education-ongoing').prop('checked'),
                access: 2,
            },
            success: function (wrapper) {

                //check if valid form was submitted, dont allow invalid form to continue
                if (wrapper.output.valid != false) {

                    //grab next step
                    elgg.get('ajax/view/profile-steps/stepThree', {
                        success: function (output) {
                            changeStepProgress(4);
                            $('#step').html(output).focus();

                        }
                    });

                    //update profile strength percent
                    elgg.get('ajax/view/profileStrength/info', {
                        success: function (output) {

                            $('#profileInfo').html(output);

                        }
                    });

                } else {

                    //show user what fields still need to be entered
                    $('.gcconnex-education-entry input').each(function () {
                        if ($.trim($(this).val()) == '') {
                            $(this).addClass('error').attr('aria-invalid', "true");
                        } else {
                            $(this).removeClass('error').removeAttr('aria-invalid', "true");
                        }
                    });

                    //handling the end year input and present checkbox
                    if ($('.gcconnex-education-ongoing').prop('checked') == false) {
                        if ($.trim($('#end-year-new').val()) == '') {
                            $('#end-year-new').addClass('error').attr('aria-invalid', "true");
                        } else {
                            $('#end-year-new').removeClass('error').removeAttr('aria-invalid', "true");
                        };
                    } else {
                        $('#end-year-new').removeClass('error').removeAttr('aria-invalid', "true");
                    };

                    if (wrapper.output.dates) {
                        $('#start-year-new').addClass('error').attr('aria-invalid', "true");
                        $('#end-year-new').addClass('error').attr('aria-invalid', "true");
                    }

                }
            }
        });
    });

    //skip to next step
    $('#skip').on('click', function () {
        elgg.get('ajax/view/profile-steps/stepThree', {
            success: function (output) {
                changeStepProgress(4);
                $('#step').html(output).focus();

                elgg.get('ajax/view/profileStrength/info', {
                    success: function (output) {

                        $('#profileInfo').html(output);
                    }
                });
            }
        });
    });
</script>

<style>

    .error {
        border-color: #a94442 !important;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    }

</style>
