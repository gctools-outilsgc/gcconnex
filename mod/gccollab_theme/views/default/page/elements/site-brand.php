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
if( _elgg_services()->session->get('language') == 'en'){
    $graphic_lang = 'en';
}else{
    $graphic_lang = 'fr';
}

// cyu - strip off the "GCconnex" branding bar for the gsa
if (elgg_is_active_plugin('gc_fedsearch_gsa') && ((!$gsa_usertest) && strcmp($gsa_agentstring,strtolower($_SERVER['HTTP_USER_AGENT'])) == 0) || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false ) {

} else {
?>

    <div id="app-brand">
        <div class="container">
            <div class="row">
                <div class="brand col-xs-8 col-sm-9 col-md-6 col-lg-4">
                   <object type="image/svg+xml" tabindex="-1" data="<?php echo $site_url ?>/mod/gccollab_theme/graphics/sig-blk-<?php echo $graphic_lang ?>.svg"></object>
                    <span class="wb-inv"><?php echo elgg_echo('wet:gc');?></span>
                </div>
                <section class="col-lg-6 col-md-5 hidden-sm hidden-xs">
                    <?php if( $user->user_type === 'federal' ): ?>
                        <ul id="" class="pull-left list-unstyled mrgn-bttm-0">
                            <li class="pull-left tool-link">
                            <a href="<?php echo elgg_echo('wet:gcpediaLink');?>">
                                <span class="bold-gc">GC</span><?php echo elgg_echo('wet:barGCpedia');?>
                            </a>
                            </li>
                            <li class="pull-left tool-link">
                            <a href="<?php echo elgg_echo('wet:gcintranetLink-toolsHead');?>">
                               <span class="bold-gc">GC</span>intranet
                            </a>
                            </li>
                            <li class="pull-left tool-link">
                            <a href="<?php echo elgg_echo('wet:gcdirectoryLink');?>">
                               <span class="bold-gc">GC</span><?php echo elgg_echo('wet:barDirectory');?>
                            </a>
                            </li>
                            <li class="pull-left tool-link">
                            <a href="<?php echo elgg_echo('wet:gcconnexLink');?>">
                               <span class="bold-gc">GC</span>connex
                            </a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </section>
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
                <div class="col-lg-2 col-md-6 col-sm-3">
                    <?php echo elgg_view('page/elements/chng-lang', $vars); ?>
                </div>
            </div>
            <div class="row">
                <section class="col-sm-3 col-xs-5">
                    <div class="app-name">
                    <a href="<?php echo $site_url; ?>">
                        <span><span class="bold-gc">GC</span>collab</span>
                    </a>
                    </div>
                </section>
                <div class="col-md-6 col-sm-4 hidden-xs">
                    <?php echo elgg_view('search/search_box', $vars); ?>
                </div>
                <div class="col-md-3 col-sm-5 col-xs-7">
                    <?php echo elgg_view('page/elements/topbar_wrapper', $vars);?>
                </div>
            </div>
        </div>

    </div>

<?php } ?>