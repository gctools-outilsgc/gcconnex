<?php
/**
 * Tidypics Plugin
 *
 * Index page Latest Photos widget for Widget Manager plugin
 *
 */

// get widget settings
$count = sanitise_int($vars["entity"]->tp_latest_photos_count, false);
if(empty($count)){
        $count = 12;
}

$prev_context = elgg_get_context();
elgg_set_context('front');
$image_html = elgg_list_entities(array(
                'type' => 'object',
                'subtype' => 'image',
                'limit' => $count,
                'full_view' => false,
                'list_type_toggle' => false,
                'list_type' => 'gallery',
                'pagination' => false,
                'gallery_class' => 'tidypics-gallery-widget',
              ));
elgg_set_context($prev_context);
echo $image_html;
