<?php
/**
 * WET 4 Footer
 * 
 */

// footer

$site_url = elgg_get_site_url();
$about = $site_url .'about-a_propos';
$terms = $site_url .'terms-termes';
$priv = $site_url .'privacy-confidentialite';
?>


  <!-- This contains the bottom Footer Links -->
    <div class="container">
		<nav role="navigation">
			<h2>About this site</h2>
            
            <?php  
            if(!elgg_is_logged_in()){
                //Test is the user is logged in and give them links to register in the footer
                //echo 'You not logged in braj';
                echo elgg_view('page/elements/footer_register', $vars);
            }
            
            ?>


			<div class="row">

                <section class="col-sm-4">
                <h3>
                    <?php echo elgg_echo('wet:footTitleAbout');?>
                </h3>
                <ul class="list-unstyled">
		                  <li><a href="<?php echo $about;?>"><?php echo elgg_echo('wet:footAbout');?></a></li>
                           <li><a href="#"><?php echo elgg_echo('wet:footTutorials');?></a></li>
                           <li><a href="<?php echo $priv;?>"><?php echo elgg_echo('wet:footPrivacy');?></a></li>
                           <li><a href="<?php echo $terms;?>"><?php echo elgg_echo('wet:footTerms');?></a></li>
                           <li><a href="<?php echo elgg_get_site_url() . 'mod/contactform/'; ?>"><?php echo elgg_echo('contactform:help_menu_item'); ?></a></li>
	                   </ul>
                </section>
                <section class="col-sm-4">
                <h3>
                    <?php echo elgg_echo('wet:footTitleNews');?>
                </h3>
                <ul class="list-unstyled">
		                  <li><a href="#">GCconnex News</a></li>
		                  <li><a href="#">GCconnex Stats</a></li>
	                   </ul>
                </section>
                <section class="col-sm-4">
                <h3>
                    <?php echo elgg_echo('wet:footTitleSocial');?>
                </h3>
                <ul class="list-unstyled">
		                  <li><a href="https://twitter.com/gcconnex">Twitter</a></li>
	                   </ul>
                </section>

			</div>
		</nav>
	</div>
    
    
    
    <!-- GC Info that will be at the bottom of the footer -->
    <div class="brand">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 visible-sm visible-xs tofpg">
                    <a href="#wb-cont">Top of Page <span class="glyphicon glyphicon-chevron-up"></span></a>
                </div>
                <div class="col-xs-6 col-md-12 text-right">
                    <object type="image/svg+xml" tabindex="-1" role="img" data="<?php echo $site_url ?>/mod/wet4/graphics/wmms-blk.svg" aria-label="Symbol of the Government of Canada"></object>
                </div>
            </div>
        </div>
    </div>