<?php
/**
 * WET 4 Top Bar
 * 
 
 
 We get the site URL into a var to route to the image files in the graphics folder.
 */



$site_url = elgg_get_site_url();
?>



        <!-- Top Black Bar with Links and Lang select -->
		<div id="wb-bar">
			<div class="container">
				<div class="row">
                    <object id="gcwu-sig" type="image/svg+xml" tabindex="-1" role="img" data="<?php echo $site_url ?>/mod/wet4/graphics/sig-en.svg" aria-label="Government of Canada"></object>
                    <ul id="gc-bar" class="list-inline">
                        <li><a href="http://www.canada.ca/en/index.html" rel="external">Canada.ca</a></li>
                        <li><a href="http://www.canada.ca/en/services/index.html" rel="external">Services</a></li>
                        <li><a href="http://www.canada.ca/en/gov/dept/index.html" rel="external">Departments</a></li>
                        <li id="wb-lng"><h2>Language selection</h2>
                            <ul class="list-inline">
                                <li><a lang="fr" href="index-fr.html">Français</a></li>
                            </ul>
                        </li>
                    </ul>
					<section class="wb-mb-links col-xs-12 visible-sm visible-xs" id="wb-glb-mn">
						<h2>Search and menus</h2>
						<ul class="pnl-btn list-inline text-right">
                            <li><a href="#mb-pnl" title="Search and menus" aria-controls="mb-pnl" class="overlay-lnk btn btn-sm btn-default" role="button"><span class="glyphicon glyphicon-search"><span class="glyphicon glyphicon-th-list"><span class="wb-inv">Search and menus</span></span></span></a></li>
                        </ul>
                        <div id="mb-pnl"></div>
					</section>
				</div>
			</div>
		</div>
        <!-- End of Black bar with Links and Lang Select -->