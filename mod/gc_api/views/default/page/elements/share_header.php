<?php

/*
 * filename: share_header.php
 * author: Nicholas Pietrantonio
 * purose: minimalist header file custom made for share form.
 */
$site_url = elgg_get_site_url();


if( _elgg_services()->session->get('language') == 'en'){
    $graphic_lang = 'en';
}else{
    $graphic_lang = 'fr';
}
?>

<div>
    <div class="clearfix row" style="max-height: 30px">
        <div class="col-xs-6" style="max-height: 30px">

        
        <object style="max-height: 30px" type="image/svg+xml" tabindex="-1" data="<?php echo $site_url ?>mod/wet4/graphics/sig-blk-<?php echo $graphic_lang ?>.svg"></object>
        <span class="wb-inv">
            <?php echo elgg_echo('wet:gc');?>
            </span>
        </div>
        <div class="col-xs-offset-6"></div>
    </div>

    <div class="row">
        <div class="col-xs-1 ">
            <img class="img-responsive mrgn-tp-md" src="<?php echo $site_url?>mod/wet4/graphics/gcconnex_icon_color.png" alt="graphic element for gcconnex" />
        </div>
        <div class="col-xs-11">
            <h1 class="h3 mrgn-tp-md share-title"><?php echo elgg_echo('gcconnexshare:share_title');?></h1>
        </div>
    </div>
</div>