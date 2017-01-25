<?php
/*
* Displays the official check in the group summary view
*
* @version 1.0
* @author Nick
*/

$entity = $vars['entity'];
//Tests if the entity is an official group
if($entity->official_group == true){
   
echo '<img class="official-check" style="max-width: 26px;" title="'. elgg_echo('gc_off_group:badge_text') .'"  src="'.elgg_get_site_url().'mod/gc_official_groups/graphics/official_check.svg">'; 
}
