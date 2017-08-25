<?php
/**
 * WET 4 Footer
 *
 */

// footer

$site_url = elgg_get_site_url();
$about = $site_url .'about-a_propos';
$terms = $site_url .'terms';
$priv = $site_url .'privacy-confidentialite';

//check lang of current user and change Canada graphic based on language
if( _elgg_services()->session->get('language') == 'en'){
    $graphic_lang = 'en';
}else{
    $graphic_lang = 'fr';
}
?>


  <!-- This contains the bottom Footer Links -->
    <div class="container">
		<nav role="navigation">
			<h2>About this site</h2>

			<div class="row">

                <section class="col-sm-3">
                <h3>
                    <?php echo elgg_echo('wet:footTitleAbout');?>
                </h3>
                <ul class="list-unstyled">
		                  <li><a href="<?php echo $about;?>"><?php echo elgg_echo('wet:footAbout');?></a></li>

                           <li><a href="<?php echo $priv;?>"><?php echo elgg_echo('wet:footPrivacy');?></a></li>
                           <li><a href="<?php echo $terms;?>"><?php echo elgg_echo('wet:footTerms');?></a></li>

	                   </ul>
                </section>
            <section class="col-sm-3">
                <h3>
                    <?php echo elgg_echo('help');?>
                </h3>
                <ul class="list-unstyled">
                    <li>
                        <a href="<?php echo elgg_echo('wet:tutorialLink');?>" target="_blank">
                            <?php echo elgg_echo('wet:footTutorials');?>
                        </a>
                    </li>
                    <li>
                        <?php if(elgg_is_active_plugin('freshdesk_help')){
                        echo '<a href="'. elgg_get_site_url() . 'help/knowledgebase">'.elgg_echo('freshdesk:page:title').'</a>';
                      } else {
                        echo '<a href="'. elgg_get_site_url() . 'mod/contactform/">'.elgg_echo('contactform:help_menu_item').'</a>';
                      }
                        ?>
                    </li>
                </ul>
            </section>
            <section class="col-sm-3">
                <h3>
                    <?php echo elgg_echo('wet:footGCtools');?>
                </h3>
                <ul class="list-unstyled">
                    <li>
                        <a href="<?php echo elgg_echo('wet:gcintranetLink-toolsFoot');?>">GCintranet</a></li>
                    <li>
                        <a href="<?php echo elgg_echo('wet:gcpediaLink');?>">GC<?php echo elgg_echo('wet:barGCpedia');?></a></li>
                    <li>
                        <a href="<?php echo elgg_echo('wet:gcdirectoryLink');?>">GC<?php echo elgg_echo('wet:barDirectory');?></a></li>
                    <li>
                        <a href="<?php echo elgg_echo('wet:gccollabLink');?>">GCcollab</a></li>
	                   </ul>
                </section>
                <section class="col-sm-3">
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
                <div class="col-md-8 col-xs-12">
                    <a href="https://www.canada.ca/<?php echo $graphic_lang; ?>.html">
                     <object type="image/svg+xml" tabindex="-1" data="<?php echo $site_url; ?>/mod/gcconnex_theme/graphics/sig-blk-<?php echo $graphic_lang; ?>.svg"></object>
                    <span class="wb-inv"><?php echo elgg_echo('wet:gc');?></span>
                    </a>
                </div>
                <div class="col-xs-6 visible-sm visible-xs tofpg">
                    <a href="#wb-cont">Top of Page <span class="glyphicon glyphicon-chevron-up"></span></a>
                </div>
                <div class="col-xs-6 col-md-4 text-right">
                    <object type="image/svg+xml" tabindex="-1" role="img" data="<?php echo $site_url; ?>/mod/gcconnex_theme/graphics/wmms-blk.svg" aria-label="Symbol of the Government of Canada"></object>
                </div>
            </div>
        </div>
    </div>
