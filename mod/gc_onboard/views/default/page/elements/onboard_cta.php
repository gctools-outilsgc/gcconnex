<?php

/**
 * This view creates a box that will appear at the top of certain pages inviting users to complete different onboarding modules.
 *
 * ['href'] = The Link
 * ['btntxt']= Button Text
 * ['desc'] = Descrption
 * ['title']= Title
 * ['type'] = Type
 * ['close_count']= How many times they closed the box
 *
 * @version 1.0
 * @author Nick
 */


$cta_href = elgg_extract('href', $vars);
$cta_btntext = elgg_extract('btntxt',$vars);
$cta_desc = elgg_extract('desc', $vars);
$cta_title = elgg_extract('title', $vars);
$cta_type = elgg_extract('type', $vars);
$cta_count = elgg_extract('close_count', $vars);

?>


<div class="onboarding-cta-holder clearfix col-sm-12">
    <div class="col-sm-8">
        <div class="col-sm-12">
            <h4 class="onboard-cta-title"><?php echo $cta_title;?></h4>
        </div>
    </div>
    <div class="col-sm-4">
        <ul class="list-unstyled onboard-cta-buttons pull-right mrgn-tp-sm">
        
            <li class="text-center pull-right">
                <?php
                echo elgg_view('output/url',array(
                   'text'=>$cta_btntext,
                   'href'=>$cta_href,
                   'class'=>'btn btn-primary',
               ));
                ?>

                
            </li>
            
            <li class="text-center pull-right onboard-cta-close mrgn-rght-md">
                <?php      
                    // The count will be tested later in the action to stop showing the popup
                    if($cta_count == 2){ //Clear language: This popup will never show again if you click no
                        $close_text = elgg_echo('onboard:closeCtaLast');
                    }else{
                        $close_text = elgg_echo('onboard:closeCta');
                    }
                    echo elgg_view('output/url', array(
                        'text'=>$close_text,
                        'href'=>'#',
                        'class'=>'close-onboard-cta',
                        'id'=>$cta_type,
                        'data-count'=>$cta_count,
            ));?>
            </li>
        </ul>
        <script>
            //Close the cta if someone doesn't want to do it.
            $(document).ready(function () {
                $('.close-onboard-cta').on('click', function () {
                    var type = $(this).attr('id');
                    var count = $(this).attr('data-count');
                    $('.onboarding-cta-holder').fadeOut('slow');
                    elgg.action('onboard/set_cta', {
                        data: {
                            type: type,
                            count: count,
                        },
                        success: function (x) {
                            
                        }
                    });
                    
                });
            });
        </script>
    </div>
</div>