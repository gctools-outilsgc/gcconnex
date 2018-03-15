<?php
$entity = elgg_extract("entity", $vars);
?>
<?php echo $entity->user["email"]; ?><br />
<?php echo elgg_view_friendly_time($entity->time_created); ?>