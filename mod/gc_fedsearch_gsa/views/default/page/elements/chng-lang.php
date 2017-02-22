<?php
/*
 * chng-lang.php
 * 
 * This styles and formats the language toggle mod.
 * 
 * @package wet4
 * @author GCTools Team
 */

// Lang Select
$site_url = elgg_get_site_url();

if (elgg_is_active_plugin('gc_fedsearch_gsa') && ((!$gsa_usertest) && strcmp($gsa_agentstring,strtolower($_SERVER['HTTP_USER_AGENT'])) == 0) || strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'gsa-crawler') !== false ) {
  
  } else {
?>
    <section id="wb-lng" class="visible-md visible-lg text-right">
            <h2 class="wb-inv"><?php echo elgg_echo('wet:LangSel')?></h2>
            <div class="row">
                <div class="col-md-12">
                    <ul class="list-inline margin-bottom-none">
                        <li><?php echo elgg_view('toggle_language/toggle_lang');?></li>
                    </ul>
                </div>
            </div>
    </section>
<?php 

}