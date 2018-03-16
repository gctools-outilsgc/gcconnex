<?php
/*
 * intro.php
 *
 * First part loaded of profile module. Presents the user with message as to what this module will do for them.
 */
?>
<h1 class="wb-inv"><?php echo elgg_echo('profilemodule:title'); ?></h1>
<div tabindex="-1" class="col-md-8 clearfix" id="step" aria-live="assertive">
    <h2>
        <?php echo elgg_echo('onboard:profile:intro:title'); echo elgg_view('page/elements/step_counter', array('current_step'=>1, 'total_steps'=>6, 'class' => 'mrgn-tp-md wb-inv'));?>
    </h2>
    <p>
        <?php echo elgg_echo('onboard:profile:intro:description'); ?>
    </p>

    <button type="button" class="mrgn-bttm-md mrgn-tp-lg btn btn-primary btn-lg pull-right" id="start">
        <?php echo elgg_echo('onboard:profile:intro:start'); ?>
    </button>
</div>

<div class="col-md-4">
    <div class="panel panel-custom">
        <div class="panel-heading"> <h2 class="panel-title"><?php echo elgg_echo('onboard:steps'); ?></h2></div>
        <div class="panel-body" id="step-progress" aria-hidden="true">
            <?php echo elgg_view('page/elements/step_counter', array('current_step'=>1, 'total_steps'=>7, 'class' => 'mrgn-tp-md'));?>
        </div>
    </div>


</div>
