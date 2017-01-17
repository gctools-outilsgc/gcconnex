<?php

$entity = $vars['entity'];
//Tests if the entity is an official group
if($entity->official_group){
   
echo '<img class="official-check" style="max-width: 26px;" title="official group"  src="'.elgg_get_site_url().'mod/gc_official_groups/graphics/official_check.svg">'; 
}
