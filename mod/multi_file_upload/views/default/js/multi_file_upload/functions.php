<?php

 ?>
//<script>

/*
 * get_file_tools_settings
 *
 * Elgg doesn't have a way to get plugin settings through javascript( not that I found at least)
 *
 * @author Ethan Wallace
 * @return [Array or string] [<Array of file types from plugin settings>]
 */
function get_file_tools_settings(type){

  //get plugin setting from file_tools
  var fileExtentions = "<?php echo elgg_get_plugin_setting('allowed_extensions', 'file_tools'); ?>";

  if(type == 'multi'){

    //split for proper format
    var fileArray = fileExtentions.split(",");

    //remove whitesace
    for(var x = 0; x < fileArray.length; x++){
      fileArray[x] = fileArray[x].trim();
    }

    //return array of file extentions
    return fileArray;
  } else {
    return fileExtentions;
  }
}
