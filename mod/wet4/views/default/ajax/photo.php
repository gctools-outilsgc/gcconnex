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
    $path = $img->getFilenameOnFilestore();

	list($width, $height, $type, $attr) = getimagesize($path);


    $image = elgg_view_entity_icon($img, 'master', array(
        'img_class' => '',
        'href' => '',
        ));

   echo '<div style="min-width:'.$width.'px;min-height:'.$height.'px;">' . $image . '</div>';
