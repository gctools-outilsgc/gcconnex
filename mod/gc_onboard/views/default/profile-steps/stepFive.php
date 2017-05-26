<?php
/*
 * stepFive.php
 *
 * Fifth step of profile module. Avatar upload.
 */

$user = get_loggedin_user()->username;
$site_url = elgg_get_site_url();
$profile_link = $site_url . 'profile/' . $user;
?>

<?php echo elgg_view('avatar/upload', array('entity' =>  elgg_get_logged_in_user_entity())); ?>

<div class="mrgn-bttm-md mrgn-tp-md pull-right">
    <button type="button" id="onboard-finish" class="btn btn-primary btn-lg mrgn-tp-md mrgn-lft-sm">
        <?php echo elgg_echo('onboard:profile:finish'); ?>
    </button>
</div>

<script>
        //upload avatar
        $('.elgg-form-onboard-upload').on("submit", function (event) {

            //do upload though ajax
            $(this).ajaxSubmit({
                dataType: 'json',
                data: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function (response, status, xhr) {
                    if (response) {
                        if (response.system_messages) {
                            elgg.register_error(response.system_messages.error);
                            elgg.system_message(response.system_messages.success);
                        }
                    }

                    //update profile strength percent
                    elgg.get('ajax/view/profileStrength/info', {
                        success: function (output) {

                            $('#profileInfo').html(output);
                        }
                    });

                    //update profile card to show new avatar
                    elgg.get('ajax/view/profileStrength/infoCard', {
                        success: function (output) {

                            $('#infoCard').html(output);
                        }
                    });

                },
                error: function (xhr, status) {
                    elgg.register_error(elgg.echo('actiongatekeeper:uploadexceeded'));

                }
            });

            // this was bubbling up the DOM causing a submission
            event.preventDefault();
            event.stopPropagation();
        });

        //stop page refresh
        $('#onboard-avatar-upload').on('click', function (e) {
            e.preventDefault();
        });

        $('#onboard-finish').on('click', function(){
           window.location.replace("<?php echo $profile_link; ?>")
        });
</script>
