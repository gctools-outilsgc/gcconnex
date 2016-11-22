<?php
/*
 * stepFour.php - Welcome
 *
 * Final step of welcome module. Gives additional information on other features of GCconnex. 
 */

?>

<div class="panel-heading clearfix">
    <h2 class="pull-left"><?php echo elgg_echo('onboard:featureTitle');?></h2>
    <div class="pull-right">
        <?php echo elgg_view('page/elements/step_counter', array('current_step'=>5, 'total_steps'=>5));?>

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
                <h4><?php echo elgg_echo('search');?></h4>
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

        <button type="button" class="btn btn-primary got-it" data-dismiss="modal"><?php echo elgg_echo('groupTour:done'); ?></button>

    </div>

    <script>

        //set values so the pop up doesnt come up again
    $('.got-it').on('click', function () {

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
