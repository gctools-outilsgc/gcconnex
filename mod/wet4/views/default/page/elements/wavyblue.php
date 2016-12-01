<?php
/*
 * wavyblue.php
 * 
 * Holder for site branding, GC FIP (If GCconnex theme is active), and search. *Sidenote - this file is called wavy blue because the old wet template had a wonderful wavy blue bar to hold the site branding, so we kept the name :3 
 * 
 * @package wet4
 * @author GCTools Team
 */


$site_url = elgg_get_site_url();
//check lang of current user and change Canada graphic based on language
if( _elgg_services()->session->get('language') == 'en'){
    $graphic_lang = 'en';
}else{
    $graphic_lang = 'fr';
}
//If GCconnex theme is not active, display the site name as a link in the top left
$site_name = elgg_view('output/url', array(
    'href'=>elgg_get_site_url(),
    'text'=>elgg_get_config('sitename'),

));


?>
        <div class="row">
            <div class="brand col-xs-8 col-sm-9 col-md-6">
                <!-- LOGO -->
                <h1><?php echo $site_name; ?></h1>
            </div>

            <section class="wb-mb-links col-xs-4 col-sm-3 visible-sm visible-xs" id="wb-glb-mn">
                <h2><?php echo elgg_echo('wet:search');?></h2>
                <ul class="list-inline text-right chvrn">
                <li><a href="#mb-pnl" title="<?php echo elgg_echo('wet:search');?>" aria-controls="mb-pnl" class="overlay-lnk" role="button">
                        <span class="glyphicon glyphicon-search">
                            <span class="glyphicon glyphicon-th-list">
                            <span class="wb-inv">
                                <?php echo elgg_echo('wet:search');?>
                            </span>
                            </span>
                        </span>
                        </a>
                    </li>
                </ul>
                <div id="mb-pnl"></div>
            </section>

            <?php echo elgg_view('search/search_box', $vars); ?>
        </div>

        <!-- End of Beautiful Wavy Blue Bar at the top -->
