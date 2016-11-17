<?php

/**
 * This view creates a box that will appear at the top of group profile page so that the user stays within the onboarding proccess
 *
 * ['href'] = The Link
 * ['btntxt']= Button Text
 * ['desc'] = Descrption
 * ['title']= Title
 *
 * @version 1.0
 * @author Nick
 */


$cta_href = elgg_extract('href', $vars);
$cta_btntext = elgg_extract('btntxt',$vars);
$cta_desc = elgg_extract('desc', $vars);
$cta_title = elgg_extract('title', $vars);

$onboard_page = elgg_extract('group_page', $vars);

?>


<div class="onboarding-cta-holder clearfix col-sm-12">
    <div class="col-sm-9">
        <div class="col-sm-12">
            <?php if($onboard_page){ 
                      echo '<h3 class="onboard-cta-title mrgn-tp-sm">';
                      echo $cta_title;
                      echo '</h3>';
                  } else {
                      echo '<h4 class="onboard-cta-title">';
                      echo $cta_title;
                      echo '</h4>';
                  }
                ?>
            <div class="onboard-cta-desc">
                <?php echo $cta_desc; ?>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <ul class="list-unstyled onboard-cta-buttons pull-right mrgn-tp-sm">

            <li class="text-center pull-right">
                <?php
                if($cta_btntext && $cta_href){
                echo elgg_view('output/url',array(
                   'text'=>$cta_btntext,
                   'href'=>$cta_href,
                   'class'=>'btn btn-primary',
               ));
                    }
                ?>
            </li>
   
        </ul>
    </div>
</div>
