<?php
/**
 * WET 4 Site Branding
 *
 */

// footer
//echo elgg_view('core/account/login_dropdown');
$site_url = elgg_get_site_url();

// cyu - strip off the "GCconnex" branding bar for the gsa
if (strcmp('gsa-crawler',strtolower($_SERVER['HTTP_USER_AGENT'])) != 0) {
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
                <div class="col-sm-6 col-sm-offset-3 hidden-xs">
                    <?php if (!elgg_get_plugin_setting('ExtTheme', 'wet4')) {?>
                    <div id="tool-link" class="pull-right">
                    <div class="pull-right tool-link">
                        <a href="<?php echo elgg_echo('wet:gcintranetLink-toolsHead');?>">
                        <img class="tool-link-icon" src="<?php echo $site_url.'/mod/wet4/graphics/intranet_icon.png'?>" alt="GCintranet"/><span class="bold-gc">GC</span>intranet</a>

                    </div>
                    <div class="pull-right tool-link">
                        <a href="<?php echo elgg_echo('wet:gcpediaLink');?>">
                        <img class="tool-link-icon" src="<?php echo $site_url.'/mod/wet4/graphics/pedia_icon.png';?>" alt="GCpedia" /><span class="bold-gc">GC</span><?php echo elgg_echo('wet:barGCpedia');?></a>


                    </div>

                    </div>
                   <?php }?>
                </div>
            </div>
        </div>

    </div>

<?php } ?>
