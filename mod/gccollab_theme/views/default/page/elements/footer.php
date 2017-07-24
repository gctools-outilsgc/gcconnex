<?php
/**
 * WET 4 Footer displays links to various important information
 *
 * Aug 12 2016 - CYu - cleaned up footer
 */

$site_url = elgg_get_site_url();
$user = elgg_get_logged_in_user_entity();

$stats = "{$site_url}stats";
if ( strcmp(_elgg_services()->session->get('language'),'en') == 0 ) {
    // english links (under about)
    $about = "{$site_url}about";
    $terms = "{$site_url}terms";
    $priv = "{$site_url}privacy";

    $faq = "{$site_url}faq";

} else {
    // french links (under about)
    $about = "{$site_url}a_propos";
    $terms = "{$site_url}termes";
    $priv = "{$site_url}confidentialite";

    $faq = "{$site_url}qfp";
}

$feedbackText= elgg_echo('wet:feedbackText');

?>

<!-- This contains the bottom Footer Links -->
<div class="container">
    <nav role="navigation">
        <h2>About this site</h2>

        <?php
        //Test is the user is logged in and give them links to register in the footer
        if (!elgg_is_logged_in())
            echo elgg_view('page/elements/footer_register', $vars);
        ?>

        <div class="row">

            <!-- About -->
            <section class="col-sm-3">
                <h3><?php echo elgg_echo('wet:footTitleAbout');?></h3>
                <ul class="list-unstyled">
                    <li><a href="<?php echo $about;?>"><?php echo elgg_echo('wet:footAbout');?></a></li>
                    <li><a href="<?php echo $priv;?>"><?php echo elgg_echo('wet:footPrivacy');?></a></li>
                    <li><a href="<?php echo $terms;?>"><?php echo elgg_echo('wet:footTerms');?></a></li>
                    <li><a href="<?php echo $stats;?>"><?php echo elgg_echo('wet:stats');?></a></li>
                </ul>
            </section>

            <!-- Help -->
            <section class="col-sm-3">
                <h3><?php echo elgg_echo('help');?></h3>
                <ul class="list-unstyled">
                  <li>
                    <a href="<?php echo $faq;?>"><?php echo elgg_echo('wet:footFAQ');?></a>
                  </li>
                  <?php if(elgg_is_active_plugin('gc_onboard')){ echo '<li><a href="'.elgg_get_site_url().'tutorials">'.elgg_echo('onboard:footTutorials').'</a></li>'; }?>
                  <li><a href="<?php echo elgg_get_site_url() . 'mod/contactform/'; ?>"> <?php echo elgg_echo('contactform:help_menu_item'); ?> </a></li>
                   
                </ul>
            </section>

            <!-- Stay Connected -->
            <section class="col-sm-3">
                <h3><?php echo elgg_echo('wet:footTitleSocial');?></h3>
                <ul class="list-unstyled">
                <?php if( get_current_language() == "fr" ): ?>
                    <li><a href="https://twitter.com/SCT_Canada">Twitter</a></li>
                <?php else: ?>
                    <li><a href="https://twitter.com/TBS_Canada">Twitter</a></li>
                <?php endif; ?>
                    <!-- <li><a href="https://twitter.com/GCcollab">Twitter</a></li> -->
                    <li><a href="https://github.com/gctools-outilsgc/GCcollab">GitHub</a></li>
                </ul>
            </section>

            <section class="col-sm-3">
                <?php if( $user->user_type === 'federal' ): ?>
                    <h3><?php echo elgg_echo('wet:footGCtools');?></h3>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo elgg_echo('wet:gcpediaLink');?>">GC<?php echo elgg_echo('wet:barGCpedia');?></a></li>
                        <li><a href="<?php echo elgg_echo('wet:gcintranetLink-toolsFoot');?>">GCintranet</a></li>
                        <li><a href="<?php echo elgg_echo('wet:gcdirectoryLink');?>">GC<?php echo elgg_echo('wet:barDirectory');?></a></li>
                        <li><a href="<?php echo elgg_echo('wet:gcconnexLink');?>">GCconnex</a></li>
                    </ul>
                <?php endif; ?>
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
                <object type="image/svg+xml" tabindex="-1" role="img" data="<?php echo $site_url; ?>/mod/gccollab_theme/graphics/wmms-blk.svg" aria-label="Symbol of the Government of Canada"></object>
            </div>
        </div>
    </div>
</div>