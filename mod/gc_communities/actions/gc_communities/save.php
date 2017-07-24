<?php

    if( !elgg_is_xhr() ){
        register_error('Sorry, Ajax only!');
        forward();
    }

    $communities = get_input('communities');

    if( !empty($communities) ){
        elgg_set_plugin_setting('communities', $communities, 'gc_communities');
        return true;
    } else {
        return false;
    }
    