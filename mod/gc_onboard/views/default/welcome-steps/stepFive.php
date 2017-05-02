<?php
/*
 * stepFour.php - Welcome
 *
 * Final step of welcome module. Gives additional information on other features of GCconnex.
 */

?>

<div class="panel-heading clearfix">
    <h3 class="pull-left mrgn-tp-md"><?php echo elgg_echo('onboard:welcome:profile:sell:title');?></h3>
    <div class="pull-right">
        <?php echo elgg_view('page/elements/step_counter', array('current_step'=>6, 'total_steps'=>6));?>

    </div>
</div>
<div class="panel-body">
    <div class="clearfix">
        <div class="">
                  <p><?php echo elgg_echo('onboard:welcome:profile:access'); ?></p>
          <img class="img-responsive" style="margin: 0 auto 10px;" src="<?php echo elgg_get_site_url() .'mod/gc_onboard/graphics/'.elgg_echo('onboard:welcome:profile:sell:img'); ?>" alt="<?php echo elgg_echo('onboard:welcome:profile:sell:img:alt');?>" title="<?php echo elgg_echo('onboard:welcome:profile:sell:img:alt');?>" />

        </div>
        <div class="">

        <p class="mrgn-tp-sm"><?php echo elgg_echo('onboard:welcome:profile:sell:text'); ?></p>

        <?php

        $tour = elgg_view('output/url',array(
            'text'=> elgg_echo('onboard:welcome:profile:walkthrough'),
            'href'=>elgg_get_site_url().'profileonboard',
            'class'=>'btn btn-primary got-it',
        ));

        $profile = elgg_view('output/url',array(
            'text'=> elgg_echo('onboard:welcome:profile:visit'),
            'href'=>elgg_get_site_url().'profile/'.elgg_get_logged_in_user_entity()->username,
            'class'=>'btn btn-default got-it',
        ));



        ?>
        <div class="text-center mrgn-tp-md mrgn-bttm-md">
          <p><?php echo $tour; ?> or <?php echo $profile; ?></p>
        </div>

        <div class="mrgn-tp-md mrgn-bttm-md">
          <p><?php echo elgg_echo('onboard:welcome:profile:sell:moveon'); ?></p>
        </div>
      </div>
    </div>

    <div class="mrgn-bttm-md mrgn-tp-md pull-right">

        <button style="background:#047177;"  type="button" class="overlay-close btn btn-primary got-it " data-dismiss="modal"><?php echo elgg_echo('groupTour:done'); ?></button>

    </div>

    <script>

        //set values so the pop up doesnt come up again
    $('.got-it').on('click', function () {
        $('#fullscreen-fade').removeClass('fullscreen-fade');
        elgg.action("onboard/set_cta", {
            data: {
                type: 'onboard',
                count: true,
            },
            success: function (wrapper) {

            }
        });

    });

    </script>



</div>
