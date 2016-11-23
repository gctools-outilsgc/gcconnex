<?php
/**
 * WET 4 Header , Canada branding and search
 * 
 */

// footer
//echo elgg_view('core/account/login_dropdown');
$site_url = elgg_get_site_url();
//check lang of current user and change Canada graphic based on language
if( _elgg_services()->session->get('language') == 'en'){
    $graphic_lang = 'en';
}else{
    $graphic_lang = 'fr';
}



?>
        <div class="row">
            <div class="brand col-xs-8 col-sm-9 col-md-6">
               <object type="image/svg+xml" tabindex="-1" data="<?php echo $site_url ?>/mod/wet4/graphics/sig-blk-<?php echo $graphic_lang ?>.svg"></object>
                <span class="wb-inv"><?php echo elgg_echo('wet:gc');?></span>
            </div>
            
            <section class="wb-mb-links col-xs-4 col-sm-3 visible-sm visible-xs" id="wb-glb-mn">
                <h2><?php echo elgg_echo('wet:search');?></h2>
                <ul class="list-inline text-right chvrn">
                <li><a href="#mb-pnl" title="<?php echo elgg_echo('wet:search');?>" aria-controls="mb-pnl" class="overlay-lnk" role="button">
                        <span class="glyphicon glyphicon-search">
                            <span class="glyphicon glyphicon-th-list">
                            <span class="wb-inv">
                                <?php echo elgg_echo('wet:search');?>
                            </span>
                            </span>
                        </span>
                        </a>
                    </li>
                </ul>
                <div id="mb-pnl"></div>
            </section>

            <?php echo elgg_view('search/search_box', $vars); ?>
        </div>

        <!-- End of Beautiful Wavy Blue Bar at the top -->

