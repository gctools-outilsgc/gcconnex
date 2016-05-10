<?php
/*
 * Author: National Research Council Canada
 * Website: http://www.nrc-cnrc.gc.ca/eng/rd/ict/
 *
 * License: Creative Commons Attribution 3.0 Unported License
 * Copyright: Her Majesty the Queen in Right of Canada, 2015
 */

$mission_guid = $vars['mission_guid'];
$mission_guid_id = 'mission-on-page-' . $mission_guid;
?>

<div class="col-sm-12" style="margin:16px;">
	<label for="<?php echo $mission_guid_id?>" style="display:inline-block;">
		<?php echo elgg_echo('missions:mission_guid') . ': '; ?>
	</label>
	<div name="mission-on-page-guid" id="<?php echo $mission_guid_id; ?>" style="display:inline-block;">
		<?php echo $mission_guid; ?>
	</div>
</div>