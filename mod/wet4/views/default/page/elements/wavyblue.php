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
				<div id="wb-sttl" class="col-md-5">
					<a href="<?php echo $site_url ?>">
                        <span>GCconnex</span>
                    </a>
				</div>
				<object id="wmms" type="image/svg+xml" tabindex="-1" role="img" data="<?php echo $site_url ?>/mod/wet4/graphics/wmms.svg" aria-label="Symbol of the Government of Canada"></object>
				<section id="wb-srch" class="visible-md visible-lg">
					<h2>Search</h2>
					<form action="https://google.ca/search" method="get" role="search" class="form-inline">
                        <div class="form-group">
                            <label for="wb-srch-q">Search website</label>
                            <input id="wb-srch-q" class="form-control" name="q" type="search" value="" size="27" maxlength="150" />
                            <input type="hidden" name="q" value="site:wet-boew.github.io OR site:github.com/wet-boew/" />
                        </div>
                        <button type="submit" id="wb-srch-sub" class="btn btn-default">Search</button>
                    </form>
				</section>
			</div>
		</div>
        <!-- End of Beautiful Wavy Blue Bar at the top -->