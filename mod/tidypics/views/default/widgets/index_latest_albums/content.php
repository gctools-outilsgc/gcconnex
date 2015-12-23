<?php
/**
 * Tidypics Plugin
 *
 * Index page Latest Albums widget for Widget Manager plugin
 *
 */

// get widget settings
$count = sanitise_int($vars["entity"]->tp_latest_albums_count, false);
if(empty($count)){
        $count = 6;
}

elgg_push_context('front');
$image_html = elgg_list_entities(array(
'type' => 'object',
'subtype' => 'album',
'limit' => $count,
'full_view' => false,
'pagination' => false,
));
elgg_pop_context();
echo $image_html;
