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
                <a href="<?php echo $site_url ?>"><img src="<?php echo $site_url ?>/mod/wet4/graphics/gcconnex_logo.png" alt="GCconnex Logo"><span class="wb-inv">GCconnex</span></a>
            </div>
            <section class="wb-mb-links col-xs-4 col-sm-3 visible-sm visible-xs" id="wb-glb-mn">
                <h2>Search and menus</h2>
                <ul class="list-inline text-right chvrn">
                    <li><a href="#mb-pnl" title="Search and menus" aria-controls="mb-pnl" class="overlay-lnk" role="button"><span class="glyphicon glyphicon-search"><span class="glyphicon glyphicon-th-list"><span class="wb-inv">Search and menus</span></span></span></a></li>
                </ul>
                <div id="mb-pnl"></div>
            </section>
            <!--
            <section id="wb-srch" class="col-xs-6 text-right visible-md visible-lg">
                <h2>Search</h2>
                <form action="#" method="post" name="cse-search-box" role="search" class="form-inline">
                    <div class="form-group">
                        <label for="wb-srch-q" class="wb-inv">Search website</label>
                        <input id="wb-srch-q" list="wb-srch-q-ac" class="wb-srch-q form-control" name="q" type="search" value="" size="27" maxlength="150" placeholder="Search GCconnex">
                        <datalist id="wb-srch-q-ac">
                            <!--[if lte IE 9]><select><![endif]-->
                            <!--[if lte IE 9]></select><![endif]-->
        
                        <!--</datalist>
                    </div>
                    <div class="form-group submit">
                        <button type="submit" id="wb-srch-sub" class="btn btn-primary btn-small" name="wb-srch-sub"><span class="glyphicon-search glyphicon"></span><span class="wb-inv">Search</span></button>
                    </div>
                </form>
            </section> -->
            <?php echo elgg_view('search/search_box', $vars); ?>
        </div>
		</div>
        <!-- End of Beautiful Wavy Blue Bar at the top -->