<?php 
/**
 * WET 4 Site Branding
 *
 */

// footer
//echo elgg_view('core/account/login_dropdown');
$site_url = elgg_get_site_url();

// cyu - strip off the "GCconnex" branding bar for the gsa
if (elgg_is_active_plugin('gc_fedsearch_gsa') && ((!$gsa_usertest) && strcmp($gsa_agentstring,strtolower($_SERVER['HTTP_USER_AGENT'])) == 0) || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false ) {

} else {
?>


    <div id="app-brand">
        <div class="container">
            <div class="row">
                <section class="col-lg-2 col-md-2 col-xs-8">
                    <div class="app-name">
                    <a href="<?php echo $site_url; ?>">
                        <span><span class="bold-gc">GC</span>connex</span>
                    </a>
                    </div>
                </section>
                <section class="col-lg-6 col-md-5 hidden-sm hidden-xs">
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
                        <a href="<?php echo elgg_echo('wet:gccollabLink');?>">
                           <span class="bold-gc">GC</span>collab
                        </a>
                        </li>
                    </ul>
                </section>
                <?php echo elgg_view('page/elements/chng-lang'); ?>
                <section class="wb-mb-links col-xs-4 visible-sm visible-xs" id="wb-glb-mn">
                <h2><?php echo elgg_echo('wet:search');?></h2>
                <ul class="list-inline text-right chvrn mrgn-bttm-0">
                <li><a href="#mb-pnl" title="<?php echo elgg_echo('wet:search');?>" aria-controls="mb-pnl" class="overlay-lnk" role="button">
                        <span class="glyphicon glyphicon-search">
                            <span class="wb-inv">
                                <?php echo elgg_echo('wet:search');?>
                            </span>
                        </span>
                    <span class="glyphicon glyphicon-th-list"></span>
                        </a>
                    </li>
                </ul>
                <div id="mb-pnl"></div>
                </section>

            <?php echo elgg_view('search/search_box', $vars); ?>
            </div>
        </div>

    </div>

<?php } ?>