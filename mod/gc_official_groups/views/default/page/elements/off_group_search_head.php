<?php
/*
* Adding meta to the site head for search biasing on the GSA
*
* @version 1.0
* @author Nick
*/
//Only display on a group 
if(elgg_in_context('group_profile') || elgg_instanceof(elgg_get_page_owner_entity(), 'group')){

$group = get_entity(elgg_get_page_owner_guid());
    //check if this group is an official group and add meta tag for official group
    if($group->official_group == true){      
?>
    <meta NAME="gcconnex" CONTENT="official_group">
<?php 
 }
}
?>


