<?php
/**
  * gc_splash_page start.php
  *
  * Creates a splash page for GCconnex for users to check language.
  * It then forwards them to login
  *
  * @version 1.0
  * @author Nick Pietrantonio    github.com/piet0024
 */

elgg_register_event_handler('init','system', 'splash_init');
function splash_init(){

  //Register splash page handler
   elgg_register_page_handler('splash', 'splash_page_handler');
   //css splash page
    elgg_extend_view('css/elgg', 'css/splash');

}

//Create splash page
function splash_page_handler(){
    @include (dirname ( __FILE__ ) . "/pages/splash.php");
    return true;
}
