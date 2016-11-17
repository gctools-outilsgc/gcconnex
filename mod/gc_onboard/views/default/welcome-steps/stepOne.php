<?php
/*
 * stepOne.php - Welcome
 *
 * First step asks for user's basic information or gives them an option to sync with GCdirectory
 */
?>


<div class="panel-heading clearfix">
    <h2 class="pull-left">
        <?php echo elgg_echo('onboard:welcome:one:title'); ?>
    </h2>
    <div class="pull-right">
        <?php echo elgg_view('page/elements/step_counter', array('current_step'=>2, 'total_steps'=>5));?>

    </div>
</div>


<div class="panel-body">
    <p class="mrgn-lft-sm mrgn-bttm-sm">
        <?php echo elgg_echo('onboard:welcome:one:description'); ?>
    </p>

    <?php if(elgg_is_active_plugin('geds_sync') && elgg_view_exists('welcome-steps/geds/sync')){ ?>
    <section class="alert-gc clearfix">
        <div class="clearfix">
            <div class="pull-left mrgn-lft-0">
                <i class="fa fa-info-circle fa-3x alert-gc-icon" aria-hidden="true"></i>
            </div>
            <div style="width:80%;" class="pull-left alert-gc-msg">
                <h3>
                    <?php echo elgg_echo("onboard:geds:title"); ?></h3>
                <p>
                    <?php echo elgg_echo("onboard:geds:body"); ?>
                </p>
            </div>
        </div>

        <?php echo elgg_view('welcome-steps/geds/sync');
        //echo elgg_view('welcome-steps/geds_sync_button');
        ?>

    </section>
<div id="test"></div>
    <?php } ?>
<div class="mrgn-tp-md clearfix" id="onboard-table">

        <div class="mrgn-lft-sm mrgn-bttm-sm">
            <?php
            if(elgg_is_active_plugin('geds_sync') && elgg_view_exists('welcome-steps/geds/sync')){
                echo elgg_echo('onboard:welcome:one:noGeds');
            }?>

        </div>
    <?php
    $user = elgg_get_logged_in_user_entity();

    $fields = array('Job', 'Location', 'Phone', 'Mobile');

    foreach ($fields as $field) {

        echo '<div class="basic-profile-field-wrapper col-xs-12">'; // field wrapper for css styling

        $field = strtolower($field);

        echo '<label for="' . $field . '" class="basic-profile-label ' . $field . '-label">' . elgg_echo('gcconnex_profile:basic:' . $field) . '</label>'; // field label

        $value = $user->get($field);

        // setup the input for this field
        $params = array(
            'name' => $field,
            'id' => $field,
            'class' => 'mrgn-bttm-sm gcconnex-basic-' . $field,
            'value' => $value,
        );
        echo '<div class="basic-profile-field">'; // field wrapper for css styling

        echo elgg_view("input/text", $params);

        echo '</div>'; //close div class = basic-profile-field

        echo '</div>'; //close div class = basic-profile-field


    }
    ?>
</div>

<div id="stepOneButtons" class="mrgn-bttm-md mrgn-tp-md pull-right">

        <a id="skip" class="mrgn-lft-sm btn btn-default" href="#">
            <?php echo elgg_echo('onboard:welcome:one:skip'); ?>
        </a>
        <?php
    echo elgg_view('input/submit', array(
            'value' => elgg_echo('onboard:welcome:one:submit'),
            'id' => 'onboard-info',

        ));
        ?>

</div>
    </div>

<script>

    //submit entered fields
    $('#onboard-info').on('click', function () {

        elgg.action('onboard/update-profile', {
            data: {
                section: 'details',
                job: $('.gcconnex-basic-job').val(),
                location: $('.gcconnex-basic-location').val(),
                phone: $('.gcconnex-basic-phone').val(),
                mobile: $('.gcconnex-basic-mobile').val(),
                website: $('.gcconnex-basic-website').val(),
            },
            success: function (wrapper) {
                if (wrapper.output) {
                    //alert(wrapper.output.sum);
                } else {
                    // the system prevented the action from running
                }

                //grab next step
                elgg.get('ajax/view/welcome-steps/stepTwo', {
                    success: function (output) {

                        $('#welcome-step').html(output);

                    }
                });

            }
        });
    });

    //skip to next step
    $('#skip').on('click', function () {
        elgg.get('ajax/view/welcome-steps/stepTwo', {
            success: function (output) {
                $('#welcome-step').html(output);
            }
        });
    });

</script>

<style>
    .alert-gc {
        border: 2px solid #567784;
        background: white;
        margin: 3px;
        padding:5px;
    }

    .alert-gc-icon {
        color: #567784;
        margin:10px;
    }

    .alert-gc-msg {
        margin-left:5px;
    }

    .alert-gc-msg h3 {
        margin-top:10px;

    }


</style>
