<?php
/**
 * WET 4 Site Branding
 *
 */

// footer
//echo elgg_view('core/account/login_dropdown');
$site_url = elgg_get_site_url();
$user = elgg_get_logged_in_user_entity();
//check lang of current user and change Canada graphic based on language
if( _elgg_services()->session->get('language') == 'fr'){
    $graphic_lang = 'fr';
    $account_text = 'GCcompte';
    $pilot = 'Pilote';
} else {
    $graphic_lang = 'en';
    $account_text = 'GCaccount';
    $pilot = 'Pilot';
}

// cyu - strip off the "GCconnex" branding bar for the gsa
if (elgg_is_active_plugin('gc_fedsearch_gsa') && ((!$gsa_usertest) && strcmp($gsa_agentstring,strtolower($_SERVER['HTTP_USER_AGENT'])) == 0) || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false ) {

} else {
?>

    <div id="app-brand">
        <div class="container hidden-sm hidden-xs">
            <div class="row">
                <div class="brand hidden-sm hidden-xs col-xs-8 col-sm-5 col-md-4 col-lg-4">
                   <object type="image/svg+xml" tabindex="-1" data="<?php echo $site_url ?>/mod/wet4_collab/graphics/sig-blk-<?php echo $graphic_lang; ?>.svg" aria-label="<?php echo elgg_echo('wet:gc');?>"></object>
                </div>
                <section class="hidden-sm hidden-xs col-sm-7 col-md-6 col-lg-6">
                    <ul id="" class="pull-left list-unstyled mrgn-bttm-0" style="font-weight:bold;">
                        <!-- <li class="pull-left tool-link">
                        <a href="https://message.gccollab.ca" style="color:#6b5088;">
                            <img style="width:25px; display:inline-block; margin-right:3px;" src="<?php echo $site_url ?>/mod/gccollab_theme/graphics/message_icon_pilot.png" alt=""></span>GCmessage (<?php echo $pilot; ?>)
                        </a>
                        </li> -->
                    </ul>
                </section>

                <div class="col-sm-3 col-md-2 col-lg-2">
                    <?php echo elgg_view('page/elements/chng-lang', $vars); ?>
                </div>
            </div>
        </div>

        <section class="wb-mb-links visible-sm visible-xs" id="wb-glb-mn">
            <h2><?php echo elgg_echo('wet:search');?></h2>
            <div class="purple-bg mbm d-flex">
                <div class="container align-self-center">
                    <div class="app-name">
                        <a href="<?php echo $site_url; ?>"><span><span class="bold-gc">GC</span>collab</span></a>
                    </div>
                    <div class="icons text-right">
                        <a href="#mb-pnl" title="<?php echo elgg_echo('wet:search');?>" aria-controls="mb-pnl" class="overlay-lnk" role="button">
                            <span class="glyphicon glyphicon-search"><span class="wb-inv"><?php echo elgg_echo('wet:search');?></span></span>
                            <span class="glyphicon glyphicon-th-list"><span class="wb-inv"><?php echo elgg_echo('wet:menu');?></span></span>
                        </a>
                    </div>
                </div>
            </div>
            <div id="mb-pnl" tabindex="-1"></div>
        </section>
        <div class="container">
            <div class="row">
                <section class="col-sm-2 col-xs-5 hidden-sm hidden-xs">
                    <div class="app-name">
                        <a href="<?php echo $site_url; ?>">
                            <span><span class="bold-gc">GC</span>collab</span>
                        </a>
                    </div>
                </section>
                <nav role="navigation" id="wb-sm"  data-trgt="mb-pnl" class="wb-menu hidden-sm hidden-xs col-md-6" typeof="SiteNavigationElement">
                    <div class="container nvbar"> <!-- container for screen reader text and list -->
                        <h2><?php echo elgg_echo('wet:topicmenu');?></h2>
                        <div class="row">
                            <?php echo elgg_view_menu('site'); ?>
                        </div>
                    </div>
                </nav>
                <nav role="navigation" class="wb-menu hidden-sm hidden-xs col-md-4" typeof="SiteNavigationElement">
                    <div class="container nvbar"> <!-- container for screen reader text and list -->
                        <h2 class="wb-invisible"><?php echo elgg_echo('wet:topicmenu');?></h2>
                        <ul nav="navigation" class="text-right col-md-4">
                            <?php echo (elgg_is_logged_in()) ? elgg_view('page/elements/user_menu', $vars) : elgg_view('page/elements/login_menu', $vars); ?>
                        </ul>
                    </div>
                </nav>
                <?php echo elgg_view('search/search_box', $vars); ?>
            </div>
        </div>
    </div>

<?php } ?>
