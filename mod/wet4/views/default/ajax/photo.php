<?php
    
    
    $guid = (int) get_input("guid");

    $img = get_entity($guid);

    $image = elgg_view_entity_icon($img, 'master', array(
        'img_class' => '',
        'href' => '',
        ));

    echo '<div style="min-width:200px;min-height:200px;">' . $image . '</div>';