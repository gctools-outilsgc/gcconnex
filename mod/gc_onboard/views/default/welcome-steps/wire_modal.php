<?php

/**
 * This View displays a modal popup when a user visits the wire for the first time.
 * The popup will explain what the wire is used for and all of the feautres
 * When the user clicks the confirm button, an action is run through js that will set metadata
 * 
 *
 * @version 1.0
 * @author Nick
 */
 if(elgg_is_logged_in()){
 if(elgg_in_context('thewire')){
 //Only show on the Wire and if metadata was not set
     //Once the metadata is set this view will never appear on the DOM
 
?>
<style>
    .modal-open .modal {
        background: rgba(0,0,0,0.4);
    }
</style>
<div class="row clearfix wire-button-holder">
    <button aria-hidden="true" type="button" id="wirePopup" class="btn btn-default gcconnex-edit-profile pull-right" data-toggle="modal" data-target="#showWire" data-keyboard="false" data-backdrop="static" data-colorbox-opts='{"inline":true, "href":"#showWire", "innerWidth": 800, "maxHeight": "80%"}'><?php echo elgg_echo('onboard:wireButton'); ?></button>

</div>


<div class="modal fade" id="showWire" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="panel panel-custom" id="welcome-step">
            <div class="panel-heading clearfix">
                <h2 class="pull-left"><?php echo elgg_echo('onboard:wireTitle'); ?></h2>
            </div>
            <div class="panel-body">
                <div class="additional-feature-holder clearfix">

                    <div class="col-sm-4 feature-col">
                        <div class="col-sm-12">
                            <div class="feature-image">
                                <img src="<?php echo elgg_get_site_url() .'mod/gc_onboard/graphics/wire/w_1.jpg'; ?>" alt="<?php echo elgg_echo('onboard:wireImgAlt1');?>" />
                            </div>
                        </div>
                        <div class="col-sm-12 mrgn-tp-md feature-desc">
                            
                            <?php
                                echo elgg_echo('onboard:wire1');
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4 feature-col">
                        <div class="col-sm-12">
                            <div class="feature-image">
                                <img src="<?php echo elgg_get_site_url() .'mod/gc_onboard/graphics/wire/w_2.jpg';?>" alt="<?php echo elgg_echo('onboard:wireImgAlt2');?>" />
                            </div>
                        </div>
                        <div class="col-sm-12 mrgn-tp-md feature-desc">
                            
                            <?php
                                echo elgg_echo('onboard:wire2');
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4 feature-col">
                        <div class="col-sm-12">
                            <div class="feature-image">
                                <img src="<?php echo elgg_get_site_url() .'mod/gc_onboard/graphics/wire/w_3.jpg'; ?>" alt="<?php echo elgg_echo('onboard:wireImgAlt3');?>" />
                            </div>
                        </div>
                        <div class="col-sm-12 mrgn-tp-md feature-desc">
                           
                            <?php
                                echo elgg_echo('onboard:wire3');
                            ?>
                        </div>
                    </div>
                </div>

                <div class="mrgn-bttm-md mrgn-tp-md pull-right">

                    <button type="button" class="btn btn-primary close-wire-popup" data-dismiss="modal">
                        <?php echo elgg_echo('groupTour:gotit');?>
                    </button>

                </div>

                <?php if(!elgg_get_logged_in_user_entity()->hasVisitedWire){?>
                      
                <script>
                    $(document).ready(function () {
                        $('#wirePopup').delay(800).click();

                    });
                </script>

                      <?php }?>

                <script>
                    $(document).ready(function () {
                        //Open the popup load
                        //$('#wirePopup').delay(800).click();
                        //Clicked the confirm button
                        $('.close-wire-popup').on('click', function () {
                            elgg.action('onboard/set_wire_metadata', {
                                data: {
                                    visited: 'true',
                                },
                                success: function (x) {

                                }
                            });

                        });
                    });

                </script>



            </div>

        </div>

    </div>

</div>


<?php

    }
 }
?>