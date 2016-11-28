<?php
/**
 * footer.php
 * 
 * Site footer. Contains lists for links
 * 
 * @package wet4
 * @author GCTools Team
 */

$site_url = elgg_get_site_url();
$about = $site_url .'about-a_propos';
$terms = $site_url .'terms';
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
		                  <li>Something</li>
                          <li>Something</li>
                          <li>Something</li>

	                   </ul>
                </section>
            <section class="col-sm-4">
                <h3>
                    <?php echo elgg_echo('help');?>
                </h3>
                <ul class="list-unstyled">
                        <li>Something</li>
                          <li>Something</li>
                          <li>Something</li>
                </ul>
            </section>

                <section class="col-sm-4">
                <h3>
                    <?php echo elgg_echo('wet:footTitleSocial');?>
                </h3>
                <ul class="list-unstyled">
                          <li>Something</li>
                          <li>Something</li>
                          <li>Something</li>
	                   </ul>
                </section>

			</div>
		</nav>

    <!-- GC Info that will be at the bottom of the footer -->
    <div class="brand">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 visible-sm visible-xs tofpg">
                    <a href="#wb-cont">Top of Page <span class="glyphicon glyphicon-chevron-up"></span></a>
                </div>
            </div>
        </div>
    </div>
