<?php



$dbprefix = elgg_get_config("dbprefix");

$options = array(
	"type" => "group",
	"relationship" => "related_group",
	"relationship_guid" => elgg_get_page_owner_entity()->getGuid(),
	"full_view" => false,
	"joins" => array("JOIN " . $dbprefix . "groups_entity ge ON e.guid = ge.guid"),
	"order_by" => "ge.name ASC"
);

$listing = elgg_list_entities_from_relationship($options);


//showcase in tab view
  if(!(elgg_in_context('sidebar'))){
?>

<div id="related" class="tab-pane">

    <?php

      if(elgg_is_logged_in()){
          if(elgg_get_page_owner_entity()->getOwnerEntity()->guid == elgg_get_logged_in_user_guid()){
              echo elgg_view_form("group_tools/related_groups", array("class" => "mbm"), array("entity" => elgg_get_page_owner_entity()));
          }
      }

    if (!empty($listing)) {
        echo $listing;
    } else {
        echo  "<div>" . elgg_echo("groups_tools:related_groups:none") . "</div>";
    }
    ?>
</div>
<?php
    //display in module
    } else {
      //only show if group has related groups
        if (!empty($listing)) {
            echo elgg_view_module('related_sidebar', elgg_echo('groups_tools:related_groups:widget:title'), $listing);
        }
  }
    ?>