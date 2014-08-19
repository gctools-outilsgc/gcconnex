<?php
/**
 * Tidypics Plugin
 *
 * Groups page Latest Albums widget for Widget Manager plugin
 *
 */

$count = sanitise_int($vars["entity"]->tp_latest_albums_count, false);
if(empty($count)){
        $count = 6;
}

?>
<div>
        <?php echo elgg_echo("tidypics:widget:num_albums"); ?><br />
        <?php echo elgg_view("input/text", array("name" => "params[tp_latest_albums_count]", "value" => $count, "size" => "4", "maxlength" => "4")); ?>
</div>
