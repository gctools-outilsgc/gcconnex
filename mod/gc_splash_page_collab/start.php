<?php
/**
  * Creates a splash page for GCcollab for users to check language.
  */

elgg_register_event_handler('init', 'system', 'splash_collab_init');

function splash_collab_init(){
  //Register splash page handler
  elgg_register_page_handler('splash', 'splash_collab_page_handler');
  
  //css splash page
  elgg_extend_view('css/elgg', 'css/splash_collab');
}

//Create splash page
function splash_collab_page_handler(){
  @include (dirname ( __FILE__ ) . "/pages/splash.php");
  return true;
}
