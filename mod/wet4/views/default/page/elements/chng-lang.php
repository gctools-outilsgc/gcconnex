<?php
/**
 * WET 4 Lang Select
 * 
 */

// Lang Select

$site_url = elgg_get_site_url();
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
