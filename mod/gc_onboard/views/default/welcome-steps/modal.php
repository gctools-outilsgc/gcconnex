<?php
/*
 * modal.php
 *
 * Intro to welcome modal. Gives user a choice to not show again, show later (default 1 week later) or start module.
 */

elgg_load_css('bsTable'); //bootstrap table css
//elgg_load_css('onboard-css'); //custom css.
elgg_load_js('bsTablejs'); //bootstraptable
?>

<button type="button" id="onboardPopup" class="btn btn-primary gcconnex-edit-profile hidden wb-invisible" data-toggle="modal" data-target="#editProfile" data-keyboard="false" data-backdrop="static"  data-colorbox-opts= '{"inline":true, "href":"#editProfile", "innerWidth": 800, "maxHeight": "80%"}'>I do the onboard thing</button>
<!-- Modal -->
<div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="panel panel-custom panel-onboard"  id="welcome-step">
            <?php
            //Nick - Testing for the ?last_step=true to show stepFour view instead
            //?last_step=true is set by the last step of the bootstrap tour
            $is_last_step = get_input('last_step');
            $helpLaunch = get_input('welcome');

            if($is_last_step){
                echo elgg_view('welcome-steps/stepFour');
                echo '</div>';
            }else{


            ?>
            <div class="panel-heading clearfix">

                <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>-->

                <h2 class="pull-left"> <?php echo elgg_echo('onboard:welcome:intro:title'); ?></h2>
                <div class="pull-right">
                    <?php echo elgg_view('page/elements/step_counter', array('current_step'=>1, 'total_steps'=>5));?>

                </div>


            </div>

            <div class="panel-body" >

                <p>
                    <?php echo elgg_echo('onboard:welcome:intro:description');?>
                </p>

                <div class="text-right">
                    <?php
                        //if user launches welcome module by help/contact us
                        //they are committed to doing the whole module
                        //also so they dont chnage their metadata
                        if(!$helpLaunch){
                            ?>
                    <button type="button" class="btn btn-default never-again" data-dismiss="modal">
                        <?php echo elgg_echo('onboard:closeCtaLast'); ?>
                    </button>
                    <button type="button" class="btn btn-default not-now" data-dismiss="modal">
                        <?php echo elgg_echo('onboard:welcome:intro:skip'); ?>
                    </button>
                    <?php } ?>
                    <button type="button" class="btn btn-primary start-onboard">
                        <?php echo elgg_echo('onboard:welcome:intro:start'); ?>
                    </button>
                </div>
            </div>


        </div>

        <?php  } ?>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<style>
    .modal-open .modal {
        background: rgba(0,0,0,0.4);
    }

</style>
<script>

    $('.start-onboard').on('click', function () {
        elgg.get('ajax/view/welcome-steps/stepOne', {
            success: function (output) {

                $('#welcome-step').html(output);

            }
        });
    });

    $('.not-now').on('click', function () {

        elgg.action("onboard/set_cta", {
            data: {
                type: 'onboard',
                count: <?php echo time(); ?>,
            },
            success: function (wrapper) {

            }
        });

    });

     $('.never-again').on('click', function () {
        elgg.action("onboard/set_cta", {
            data: {
                type: 'onboard',
                count: 'passed',
            },
            success: function (wrapper) {
            }
        });
    });

</script>
