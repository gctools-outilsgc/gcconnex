<?php
/*
 * intro.php
 *
 * First part loaded of profile module. Presents the user with message as to what this module will do for them.
 */
?>
<div class="col-md-8 clearfix" id="step">
    <h1>
        <?php echo elgg_echo('onboard:profile:intro:title'); ?>
    </h1>
    <p>
        <?php echo elgg_echo('onboard:profile:intro:description'); ?>
    </p>

    <a class="mrgn-bttm-md mrgn-tp-lg btn btn-primary btn-lg pull-right" href="#" id="start">
        <?php echo elgg_echo('onboard:profile:intro:start'); ?>
    </a>
</div>

<div class="col-md-4">
    <div class="panel panel-custom">
        <div class="panel-heading"> <h2 class="panel-title"><?php echo elgg_echo('onboard:steps'); ?></h2></div>
        <div class="panel-body" id="step-progress">
            <?php echo elgg_view('page/elements/step_counter', array('current_step'=>1, 'total_steps'=>6, 'class' => 'mrgn-tp-md'));?>
        </div>
    </div>


</div>
