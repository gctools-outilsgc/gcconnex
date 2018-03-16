<?php
/*
 * stepFour.php - Welcome
 *
 * Final step of welcome module. Gives additional information on other features of GCCollab.
 */
$welcomeGroup_guid = elgg_get_plugin_setting("tour_group", "gc_onboard_collab");
if(!$welcomeGroup_guid){
    $welcomeGroup_guid = 967;
}
?>

<div class="panel-heading clearfix">
    <h2 class="pull-left"><?php echo elgg_echo('onboard:featureTitle');?></h2>
    <div class="pull-right">
        <?php echo elgg_view('page/elements/step_counter', array('current_step'=>7, 'total_steps'=>7));?>

    </div>
</div>
<div class="panel-body">
    <div class="additional-feature-holder clearfix">

        <div class="col-sm-4 feature-col">
            <div class="col-sm-12">
                <div class="feature-image">
                    <img src="<?php echo elgg_get_site_url() .'mod/gc_onboard_collab/graphics/additional_features/profile.jpg'; ?>" alt="<?php echo elgg_echo('onboard:featureImgAlt1');?>" />
                </div>
            </div>
            <div class="col-sm-12 mrgn-tp-md feature-desc">
                <h4><?php echo elgg_echo('onboard:feature:title1');?></h4>
                <?php
                echo elgg_echo('onboard:feature1');
                    ?>
            </div>
        </div>
        <div class="col-sm-4 feature-col">
            <div class="col-sm-12">
                <div class="feature-image">
                    <img src="<?php echo elgg_get_site_url() .'mod/gc_onboard_collab/graphics/additional_features/'.elgg_echo('onboard:img3'); ?>" alt="<?php echo elgg_echo('onboard:featureImgAlt2');?>" />
                </div>
            </div>
            <div class="col-sm-12 mrgn-tp-md feature-desc">
                <h4><?php echo elgg_echo('career');?></h4>
                <?php
                echo elgg_echo('onboard:feature2');
                ?>
            </div>
        </div>
        <div class="col-sm-4 feature-col">
            <div class="col-sm-12">
                <div class="feature-image">
                    <img src="<?php echo elgg_get_site_url() .'mod/gc_onboard/graphics/groups/g_1.jpg'; ?>" alt="<?php echo elgg_echo('onboard:featureImgAlt3');?>" />
                </div>
            </div>
            <div class="col-sm-12 mrgn-tp-md feature-desc">
                <h4><?php echo elgg_echo('onboard:feature:title2');?></h4>
                <?php
                echo elgg_echo('onboard:feature3');
                ?>
            </div>
        </div>

    </div>

    <div class="mrgn-bttm-md mrgn-tp-md pull-right">
      <button type="button" class="overlay-close btn btn-default got-it" data-dismiss="modal"><?php echo elgg_echo('groupTour:done'); ?></button>
      <?php
      //Added the group tour as optional at the end of the tour
      echo elgg_view('output/url',array(
          'text'=>elgg_echo('onboard:welcome:three:tour'),
          'href'=>elgg_get_site_url().'groups/profile/'.$welcomeGroup_guid .'?first_tour=true',
          'class'=>'btn btn-primary got-it',
      ));
      ?>
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
