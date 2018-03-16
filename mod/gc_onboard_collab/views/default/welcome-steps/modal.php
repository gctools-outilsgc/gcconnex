<?php
/*
 * modal.php
 *
 * Intro to welcome modal. Gives user a choice to not show again, show later (default 1 week later) or start module.
 *
 * Nick - Added aria-live so this modal will be focused on when the page loads.
 * Nick - Changed the whole modal
 */

elgg_load_css('bsTable'); //bootstrap table css
//elgg_load_css('onboard-css'); //custom css.
elgg_load_js('bsTablejs'); //bootstraptable

?>

<p><a id="onboardPopup" aria-hidden="true" href="#editProfile" aria-controls="mid-screen" class="overlay-lnk wb-invisible" role="button">Onboard Start</a></p>


<script>
    //Open and close new popup
    $('#onboardPopup').on('click', function(){
        $('#fullscreen-fade').toggleClass('fullscreen-fade');
        $('#editProfile').attr('aria-hidden',false);
        $('#editProfile').focus();
        $('#fullscreen-fade').on('click', function(){
            $(this).removeClass('fullscreen-fade');
            elgg.action("onboard/set_cta", {
            data: {
                type: 'onboard',
                count: <?php echo time(); ?>,
            },
            success: function (wrapper) {

            }
        });
        });
        $('.overlay-close').on('click',function(){
            $('#fullscreen-fade').removeClass('fullscreen-fade');
            elgg.action("onboard/set_cta", {
            data: {
                type: 'onboard',
                count: <?php echo time(); ?>,
            },
            success: function (wrapper) {

            }
        });
        });
        $(document).keyup(function(e){
            if(e.keyCode ==27){
                $('#fullscreen-fade').removeClass('fullscreen-fade');
                elgg.action("onboard/set_cta", {
                data: {
                    type: 'onboard',
                    count: <?php echo time(); ?>,
                },
                success: function (wrapper) {

            }
        });
            }
        })
    });


</script>
<!-- Modal -->
<div id="fullscreen-fade"></div>
<section id="editProfile" class="wb-overlay modal-content overlay-def onboard-popup" aria-live="assertive">

    <header>
        <h2><?php echo elgg_echo('onboard:gettingstarted');?></h2>
    </header>
    <div class="modal-dialog modal-lg">

        <div class=""  id="welcome-step" tabindex="-1">
            <?php
            //Nick - Testing for the ?last_step=true to show stepFour view instead
            //?last_step=true is set by the last step of the bootstrap tour
            $is_last_step = get_input('last_step');
            $helpLaunch = get_input('welcome');

            if($is_last_step){
                echo elgg_view('welcome-steps/stepFive');
                echo '</div>';
            }else{


            ?>
            <div class="clearfix">

                <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>-->

                <h3 class="pull-left mrgn-tp-md"> <?php echo elgg_echo('onboard:welcome:intro:title'); ?></h3>
                <div class="pull-right">
                    <?php echo elgg_view('page/elements/step_counter', array('current_step'=>1, 'total_steps'=>7));?>

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
                    <button type="button" class="btn btn-default never-again overlay-close" data-dismiss="modal">
                        <?php echo elgg_echo('onboard:closeCtaLast'); ?>
                    </button>
                    <button type="button" class="btn btn-default not-now overlay-close" data-dismiss="modal">
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
</section>
<!-- /.modal -->
<style>
    .modal-open .modal {
        background: rgba(0,0,0,0.4);
    }
    .fullscreen-fade{
        z-index: 1040;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background: rgba(0,0,0,0.25);
    }
    .onboard-popup{
        bottom: 0;
        /*left: 0;
        right: 0;*/
        top: 0;
        margin: auto;
        width:95%;
        max-width:1100px !important;
        max-height:800px !important;
    }
    .overlay-def header{
        padding:10px 45px 2px 1em !important;
    }

    @media (min-width: 200px) and (max-width: 1200px) {
      .onboard-popup {
        left:0;
        right:0;
      }
    }

</style>
<script>

    $('.start-onboard').on('click', function () {
        elgg.get('ajax/view/welcome-steps/stepOne', {
            success: function (output) {

                $('#welcome-step').html(output);
                $('#welcome-step').focus();

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
