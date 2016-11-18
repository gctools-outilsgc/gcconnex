<?php
/**
  * gc_splash_page start.php
  *
  *
  * @version 1.0
  * @author Nick Pietrantonio    github.com/piet0024
 */

elgg_register_event_handler('init','system', 'splash_init');
function splash_init(){

//Register splash page handler
 elgg_register_page_handler('splash_page', 'splash_page_handler');
}


//Create splash page
function splash_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/splash.php");
    return true;
}