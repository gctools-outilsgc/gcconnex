<?php
/*
 * stepFour.php - Welcome
 *
 * Final step of welcome module. Gives additional information on other features of GCconnex.
 */

?>

<div class="clearfix">
    <h3 class="pull-left mrgn-tp-md"><?php echo elgg_echo('onboard:featureTitle');?></h3>
    <div class="pull-right">
        <?php echo elgg_view('page/elements/step_counter', array('current_step'=>5, 'total_steps'=>6));?>

    </div>
</div>
<div class="panel-body">
    <div class="additional-feature-holder clearfix">

        <div class="col-sm-3 feature-col">
            <div class="col-sm-12">
                <div class="feature-image">
                    <img src="<?php echo elgg_get_site_url() .'mod/gc_onboard/graphics/additional_features/'.elgg_echo('onboard:img1'); ?>" alt="<?php echo elgg_echo('onboard:featureImgAlt1');?>" />
                </div>
            </div>
            <div class="col-sm-12 mrgn-tp-md feature-desc">
                <h4><?php echo elgg_echo('onboard:search');?></h4>
                <?php
                echo elgg_echo('onboard:feature1');
                    ?>
            </div>
        </div>
        <div class="col-sm-3 feature-col">
            <div class="col-sm-12">
                <div class="feature-image">
                    <img src="<?php echo elgg_get_site_url() .'mod/gc_onboard/graphics/additional_features/'.elgg_echo('onboard:img2'); ?>" alt="<?php echo elgg_echo('onboard:featureImgAlt2');?>" />
                </div>
            </div>
            <div class="col-sm-12 mrgn-tp-md feature-desc">
                <h4><?php echo elgg_echo('gcTour:step6');?></h4>
                <?php
                echo elgg_echo('onboard:feature2');
                ?>
            </div>
        </div>
        <div class="col-sm-3 feature-col">
            <div class="col-sm-12">
                <div class="feature-image">
                    <img src="<?php echo elgg_get_site_url() .'mod/gc_onboard/graphics/additional_features/'.elgg_echo('onboard:img3'); ?>" alt="<?php echo elgg_echo('onboard:featureImgAlt3');?>" />
                </div>
            </div>
            <div class="col-sm-12 mrgn-tp-md feature-desc">
                <h4><?php echo elgg_echo('career');?></h4>
                <?php
                echo elgg_echo('onboard:feature3');
                ?>
            </div>
        </div>
        <div class="col-sm-3 feature-col">
            <div class="col-sm-12">
                <div class="feature-image">
                    <img src="<?php echo elgg_get_site_url() .'mod/gc_onboard/graphics/additional_features/'.elgg_echo('onboard:img4'); ?>" alt="<?php echo elgg_echo('onboard:featureImgAlt4');?>" />
                </div>
            </div>
            <div class="col-sm-12 mrgn-tp-md feature-desc">
                <h4>
                    <?php echo elgg_echo('onboard:footTutorials');?></h4>
                <?php
                echo elgg_echo('onboard:feature4');
                ?>
            </div>
        </div>
    </div>

    <div class="mrgn-bttm-md mrgn-tp-md pull-right">

      <div class="mrgn-bttm-md mrgn-tp-lg pull-right">

          <?php
          echo elgg_view('input/submit', array(
                  'value' => elgg_echo('onboard:welcome:next'),
                  'id' => 'next',
              ));
          ?>

      </div>

    </div>

    <script>

    $('#next').on('click', function () {
        elgg.get('ajax/view/welcome-steps/stepFive', {
            success: function (output) {
               // var oldHeight = $('#welcome-step').css('height');
                $('#welcome-step').html(output);
                $('#welcome-step').focus();
               // var newHeight = $('#welcome-step').children().css('height');
                //console.log('new:' + newHeight + ' old:' + oldHeight);
                //animateStep(oldHeight, newHeight);
            }
        });
    });

    </script>



</div>
