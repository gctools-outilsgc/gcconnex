<?php

/**
 * Group edit form
 *
 * This view contains the group profile field configuration
 *
 * @package ElggGroups
 */

$name = elgg_extract("name", $vars);
$group_profile_fields = elgg_get_config("group");

?>
<div>
<label><?php echo elgg_echo("groups:icon"); ?></label><br />
	<?php echo elgg_view("input/file", array("name" => "icon")); ?>
</div>
<div>
	<label><?php echo elgg_echo("groups:name"); ?></label><br />
	<?php echo elgg_view("input/text", array(
		"name" => "name",
		"value" => $name,
	));
	?>
</div>
<?php

// show the configured group profile fields
/** GCconnex change: character limit, count for Brief discription for Issue #61. **/
$briefmaxlength = 350;					// Maximum length for brief description character count
foreach ((array)$group_profile_fields as $shortname => $valtype) {
	if ($valtype == "hidden") {
		echo elgg_view("input/{$valtype}", array(
			"name" => $shortname,
			"value" => elgg_extract($shortname, $vars),
		));
		continue;
	}

	$line_break = ($valtype == "longtext") ? "" : "<br />";
	$label = elgg_echo("groups:{$shortname}");
	$input = elgg_view("input/{$valtype}", array(
		"name" => $shortname,
		"value" => elgg_extract($shortname, $vars),
	));

	echo "<div><label>{$label}</label>{$line_break}{$input}</div>";
}

/** TODO: Migrate GCconnex change: character limit, count for Brief discription for Issue #61. 
$briefmaxlength = 350;					// Maximum length for brief description character count
if ($group_profile_fields > 0) {
	foreach ($group_profile_fields as $shortname => $valtype) {
		$line_break = '<br />';
		if ($valtype == 'longtext') {
			$line_break = '';
		}
		if ( $shortname == 'briefdescription' )			// Brief description with character limit, count
			echo '<div><label id="briefdescr-lbl">';
		else
			echo '<div><label>';
		echo elgg_echo("groups:{$shortname}"); if ( $shortname == 'briefdescription' ) echo elgg_echo('groups:brief:charcount') . "0/" . $briefmaxlength;
		echo "</label>$line_break";
		if ( $shortname == 'briefdescription' )			// Brief description with character limit, count
			echo elgg_view("input/{$valtype}", array(
			'name' => $shortname,
			'value' => elgg_extract($shortname, $vars),
			'maxlength' => $briefmaxlength,
			'onkeyup' => "document.getElementById('briefdescr-lbl').innerHTML = '" . elgg_echo("groups:{$shortname}") . elgg_echo('groups:brief:charcount') . " ' + this.value.length + '/" . $briefmaxlength . "';"
			));
		else
			echo elgg_view("input/{$valtype}", array(
				'name' => $shortname,
				'value' => elgg_extract($shortname, $vars)
			));
		echo '</div>';
	}
}**/