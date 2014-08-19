<?php

function phloor_str_starts_with($haystack, $needle){
    return strpos($haystack, $needle) === 0;
}

function phloor_str_ends_with($haystack, $needle){
    return strrpos($haystack, $needle) === strlen($haystack) - strlen($needle);
}
