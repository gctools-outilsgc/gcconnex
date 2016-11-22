<?php
/*
 * stepThree.php - Profile
 *
 * Third step of profile module. Asks for user'swork experience.
 */
?>

<h1>
    <?php echo elgg_echo('onboard:profile:three:title'); ?>
</h1>

<div class="onboarding-cta-holder">
    <?php echo elgg_echo('onboard:profile:work:why');?>

</div>

<?php
$user = elgg_get_logged_in_user_entity();
echo '<div class="clearfix mrgn-tp-md mrgn-bttm-md">'.elgg_view('onboard/input/work-experience').'</div>';
?>
<div class="mrgn-bttm-md pull-right">
    <a id="skip" class="mrgn-lft-sm btn btn-default" href="#">
        <?php echo elgg_echo('onboard:skip'); ?>
    </a>
    <?php
    echo elgg_view('output/url', array(
            'href'=>'#',
            'text' => elgg_echo('onboard:welcome:next'),
            'class'=>'btn btn-primary',
            'id' => 'onboard-work',
        ));
    ?>

</div>

<script>

    //add work experience
    $('#onboard-work').on('click', function () {

        elgg.action('onboard/update-profile', {
            data: {
                section: 'work',
                eguid: 'new',
                organization: $('#work-experience-new').val(),
                title: $('#title-new').val(),
                startdate: $('#startdate-new').val(),
                startyear: $('#start-year-new').val(),
                enddate: $('#enddate-new').val(),
                endyear: $('#end-year-new').val(),
                ongoing: $('.gcconnex-work-experience-ongoing').prop('checked'),
                responsibilities: $('#textarea-new').val(),
                access: 2,
            },
            success: function (wrapper) {

                //check if valid form was submitted, dont allow invalid form to continue
                if (wrapper.output.valid != false) {

                    //grab next step
                    elgg.get('ajax/view/profile-steps/stepFour', {
                        success: function (output) {
                            changeStepProgress(5);
                            $('#step').html(output);

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
                    $('.gcconnex-work-experience-entry input').each(function () {
                        if ($.trim($(this).val()) == '') {
                            $(this).addClass('error').attr('aria-invalid', "true");
                        } else {
                            $(this).removeClass('error').removeAttr('aria-invalid', "true");
                        }
                    });

                    //handling the end year input and present checkbox
                    if ($('.gcconnex-work-experience-ongoing').prop('checked') == false) {
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
        elgg.get('ajax/view/profile-steps/stepFour', {
            success: function (output) {
                changeStepProgress(5);
                $('#step').html(output);

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
    .allthewidth {
        width:100%;
    }
    .error {
        border-color: #a94442 !important;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    }

</style>
