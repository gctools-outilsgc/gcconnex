<?php
/*
* photo.php
*
* Ajax view of photos used by thumbnails on the river
*
* @package wet4
* @author GCTools Team
*/

    $guid = (int) get_input("guid");

    $img = get_entity($guid);

    $image = elgg_view_entity_icon($img, 'master', array(
        'img_class' => '',
        'href' => '',
        ));

    echo '<div style="min-width:200px;min-height:200px;">' . $image . '</div>';
