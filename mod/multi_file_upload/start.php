<?php

/*
* Multi File Upload - Creates a bootstrap multi file upload form
*
* @version 1.0
* @author Ethan Wallace
*/
//Init
elgg_register_event_handler('init','system','multi_file_init');

function multi_file_init(){

  //elgg_register_js('bootstrap-fileinput', "mod/multi_file_upload/js/fileinput.min.js");
  elgg_register_js('fileinput-fa', "mod/multi_file_upload/themes/fa/theme.js");
  elgg_require_js('multi_file_upload/fileinput');
  elgg_register_css('bootstrap-fileinput-css', "mod/multi_file_upload/css/fileinput.min.css");


  elgg_register_action("multi_file/upload", elgg_get_plugins_path() . "/multi_file_upload/actions/file/upload.php");
}
