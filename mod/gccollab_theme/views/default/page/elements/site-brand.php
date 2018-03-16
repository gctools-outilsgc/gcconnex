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
} else {
    $graphic_lang = 'en';
}

// cyu - strip off the "GCconnex" branding bar for the gsa
if (elgg_is_active_plugin('gc_fedsearch_gsa') && ((!$gsa_usertest) && strcmp($gsa_agentstring,strtolower($_SERVER['HTTP_USER_AGENT'])) == 0) || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false ) {

} else {
?>

    <div id="app-brand">
        <div class="container">
            <div class="row">
                <div class="brand col-xs-8 col-sm-5 col-md-4 col-lg-4">
                   <object type="image/svg+xml" tabindex="-1" data="<?php echo $site_url ?>/mod/wet4_collab/graphics/sig-blk-<?php echo $graphic_lang; ?>.svg"></object>
                    <span class="wb-inv"><?php echo elgg_echo('wet:gc');?></span>
                </div>
                <section class="hidden-xs col-sm-7 col-md-6 col-lg-6">
                    <ul id="" class="pull-left list-unstyled mrgn-bttm-0" style="font-weight:bold;">
                        <li class="pull-left tool-link">
                        <a href="https://account.gccollab.ca" style="color:#6b5088;">
                            <img style="width:25px; display:inline-block; margin-right:3px;" src="<?php echo $site_url ?>/mod/gccollab_theme/graphics/mini_wiki_icon.png" alt="GCcollab"></span>Account
                        </a>
                        </li>
                        <li class="pull-left tool-link">
                        <a href="https://wiki.gccollab.ca" style="color:#6b5088;">
                            <img style="width:25px; display:inline-block; margin-right:3px;" src="<?php echo $site_url ?>/mod/gccollab_theme/graphics/mini_wiki_icon.png" alt="GCcollab"></span>Wiki
                        </a>
                        </li>
                    </ul>
                </section>
                <section class="wb-mb-links visible-xs col-xs-4 col-sm-3" id="wb-glb-mn">
                    <h2><?php echo elgg_echo('wet:search');?></h2>
                    <div class="container row purple-bg mbm">
                        <div class="col-xs-6 app-name">
                            <a href="<?php echo $site_url; ?>"><span><span class="bold-gc">GC</span>collab</span></a>
                        </div>
                        <div class="col-xs-6 icons text-right">
                            <a href="#mb-pnl" title="<?php echo elgg_echo('wet:search');?>" aria-controls="mb-pnl" class="overlay-lnk" role="button">
                                <span class="glyphicon glyphicon-search mrl"><span class="wb-inv"><?php echo elgg_echo('wet:search');?></span></span>
                                <span class="glyphicon glyphicon-th-list"><span class="wb-inv"><?php echo elgg_echo('wet:menu');?></span></span>
                            </a>
                        </div>
                    </div>
                    <div id="mb-pnl"></div>
                </section>
                <div class="col-sm-3 col-md-2 col-lg-2">
                    <?php echo elgg_view('page/elements/chng-lang', $vars); ?>
                </div>
            </div>
            <div class="row">
                <section class="col-sm-3 col-xs-5 hidden-xs">
                    <div class="app-name">
                    <a href="<?php echo $site_url; ?>">
                        <span><span class="bold-gc">GC</span>collab</span>
                    </a>
                    </div>
                </section>
                <div class="col-md-5 col-sm-4 hidden-xs">
                    <?php echo elgg_view('search/search_box', $vars); ?>
                </div>
                <div class="col-md-4 col-sm-5 col-xs-12">
                    <?php echo elgg_view('page/elements/topbar_wrapper', $vars);?>
                </div>
            </div>
        </div>

    </div>

<?php } ?>