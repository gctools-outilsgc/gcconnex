<?php

$entity = $vars['entity'];
//Tests if the entity is an official group
if($entity->official_group){
   
echo '<object class="official-check" type="image/svg+xml" data="'.elgg_get_site_url().'mod/gc_official_groups/graphics/official_check.svg"></object>'; 
}
