<?php

function phloor_get_current_page_url() {
    $url = "http";
    if (strcmp("on", $_SERVER["HTTPS"]) == 0) {
        $url .= "s";
    }
    $url .= "://";

    if (strcmp("80", $_SERVER["SERVER_PORT"]) != 0) {
        $url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }

    return $url;
}


function phloor_uniqid($seed) {
    if (empty($seed)) {
        $seed = rand();
    }

    return uniqid($seed, true);
}