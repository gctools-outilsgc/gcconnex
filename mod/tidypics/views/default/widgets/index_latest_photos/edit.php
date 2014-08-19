<?php
/**
 * Tidypics Plugin
 *
 * Index page Latest Photos widget for Widget Manager plugin
 *
 */

$count = sanitise_int($vars["entity"]->tp_latest_photos_count, false);
if(empty($count)){
        $count = 12;
}

?>
<div>
        <?php echo elgg_echo("tidypics:widget:num_latest"); ?><br />
        <?php echo elgg_view("input/text", array("name" => "params[tp_latest_photos_count]", "value" => $count, "size" => "4", "maxlength" => "4")); ?>
</div>
