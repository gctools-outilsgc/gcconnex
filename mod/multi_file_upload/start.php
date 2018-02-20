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

  //extra js functions
  elgg_extend_view("js/elgg", "js/multi_file_upload/functions");

  elgg_extend_view('file_tools/sidebar/info', 'file_tools/message');

  elgg_require_js('multi_file_upload/fileinput');
  elgg_register_css('bootstrap-fileinput-css', "mod/multi_file_upload/css/fileinput.min.css");

  //custom css for bootstrap fileinput
  elgg_register_css('custom-bootstrap-fileinput', 'mod/multi_file_upload/css/custom.css');

  elgg_register_action("multi_file/upload", elgg_get_plugins_path() . "multi_file_upload/actions/file/upload.php");

}
