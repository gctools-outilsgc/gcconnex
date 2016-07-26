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

$mission_version = get_entity($mission_guid)->version;
$mission_version_id = 'mission-on-page-' . $mission_guid . '-version';
?>

<div class="col-sm-12" style="margin-top:16px;font-size:10px;">
	<div>
		<div style="display:inline-block;font-weight:bold;">
			<?php echo elgg_echo('missions:mission_guid') . ': '; ?>
		</div>
		<div name="mission-on-page-guid" id="<?php echo $mission_guid_id; ?>" style="display:inline-block;">
			<?php echo $mission_guid; ?>
		</div>
	</div>
	<div>
		<div style="display:inline-block;font-weight:bold;">
			<?php echo elgg_echo('missions:mission_version') . ': '; ?>
		</div>
		<div name="mission-on-page-version" id="<?php echo $mission_version_id; ?>" style="display:inline-block;">
			<?php echo $mission_version; ?>
		</div>
	</div>
</div>