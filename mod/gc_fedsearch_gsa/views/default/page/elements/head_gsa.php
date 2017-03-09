<?php

	global $my_page_entity;

	$tags = (is_array($my_page_entity->tags)) ? implode(",", $my_page_entity->tags) : array();
?>
  
 <meta name='keywords' content="<?php echo $tags; ?>" />