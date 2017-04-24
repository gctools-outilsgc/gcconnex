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
                <div class="col-sm-3 ">
                    <div class="app-name">
                    <a href="<?php echo $site_url; ?>">
                        <span><span class="bold-gc">GC</span>connex</span>
                    </a>
                    </div>
                </div>
                <div class="col-sm-8 col-sm-offset-1 hidden-xs">
                    <?php if (!elgg_get_plugin_setting('ExtTheme', 'wet4')) {?>
                    <ul id="" class="pull-right list-unstyled mrgn-bttm-0">
                        <li class="pull-left tool-link">
                        <a href="<?php echo elgg_echo('wet:gcpediaLink');?>">
                            <img class="tool-link-icon" src="<?php echo $site_url.'/mod/wet4/graphics/pedia_icon.png';?>" alt="GCpedia" /><span class="bold-gc">GC</span><?php echo elgg_echo('wet:barGCpedia');?>
                        </a>
                        </li>
                        <li class="pull-left tool-link">
                        <a href="<?php echo elgg_echo('wet:gcintranetLink-toolsHead');?>">
                            <img class="tool-link-icon" src="<?php echo $site_url.'/mod/wet4/graphics/intranet_icon.png'?>" alt="GCintranet"/><span class="bold-gc">GC</span>intranet
                        </a>
                        </li>
                        <li class="pull-left tool-link">
                        <a href="<?php echo elgg_echo('wet:gcdirectoryLink');?>">
                            <img class="tool-link-icon" src="<?php echo $site_url.'/mod/wet4/graphics/directory_icon.png'?>" alt="GCDirectory" /><span class="bold-gc">GC</span><?php echo elgg_echo('wet:barDirectory');?>
                        </a>
                        </li>
                        <li class="pull-left tool-link">
                        <a href="<?php echo elgg_echo('wet:gcdirectoryLink');?>">
                            <img class="tool-link-icon" src="<?php echo $site_url.'/mod/wet4/graphics/collab_icon.png'?>" alt="GCcollab" /><span class="bold-gc">GC</span>collab
                        </a>
                        </li>
                    </ul>
                   <?php }?>
                </div>
            </div>
        </div>

    </div>

<?php } ?>