<?php
/*
* Handles the GC FIP graphic in the header
*/

$site_url = elgg_get_site_url();
//check lang of current user and change Canada graphic based on language
if( _elgg_services()->session->get('language') == 'en'){
    $graphic_lang = 'en';
}else{
    $graphic_lang = 'fr';
}

?>

<object type="image/svg+xml" tabindex="-1" data="<?php echo $site_url ?>/mod/wet4/graphics/sig-blk-<?php echo $graphic_lang ?>.svg"></object>
 <span class="wb-inv"><?php echo elgg_echo('wet:gc');?></span>
