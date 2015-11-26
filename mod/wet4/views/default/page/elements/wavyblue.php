<?php
/**
 * WET 4 Footer
 * 
 */

// footer
//echo elgg_view('core/account/login_dropdown');
$site_url = elgg_get_site_url();
?>


      <!-- Beautiful Wavy Blue Bar at the top -->
		<div class="container">
			
        <div class="row">
            <div class="brand col-xs-8 col-sm-9 col-md-6">
               <object type="image/svg+xml" tabindex="-1" data="<?php echo $site_url ?>/mod/wet4/graphics/sig-blk-en.svg"></object><span class="wb-inv"> Government of Canada</span>
            </div>
            <!--
            <div class="brand col-xs-8 col-sm-9 col-md-6">
                <a href="<?php //echo $site_url ?>"><img src="<?php //echo $site_url ?>/mod/wet4/graphics/gcconnex_logo.png" alt="GCconnex Logo"><span class="wb-inv">GCconnex</span></a>
            </div>
-->
            <section class="wb-mb-links col-xs-4 col-sm-3 visible-sm visible-xs" id="wb-glb-mn">
                <h2>Search and menus</h2>
                <ul class="list-inline text-right chvrn">
                    <li><a href="#mb-pnl" title="Search and menus" aria-controls="mb-pnl" class="overlay-lnk" role="button"><span class="glyphicon glyphicon-search"><span class="glyphicon glyphicon-th-list"><span class="wb-inv">Search and menus</span></span></span></a></li>
                </ul>
                <div id="mb-pnl"></div>
            </section>

            <?php echo elgg_view('search/search_box', $vars); ?>
        </div>
		</div>
        <!-- End of Beautiful Wavy Blue Bar at the top -->