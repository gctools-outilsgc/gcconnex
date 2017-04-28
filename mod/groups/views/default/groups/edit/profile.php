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

<div class="form-group>">
<div>
<label for="icon"><?php echo elgg_echo("groups:icon"); ?></label><br />
	<?php echo elgg_view("input/file", array("name" => "icon",
        "id" => "icon")); ?>
</div>
<div class="mrgn-tp-md">
    <label for="name" class="required"><span class="field-name"><?php echo elgg_echo("groups:name"); ?></span> <strong class="required"><?php echo elgg_echo("groups:required"); ?></strong></label><br />
	<?php echo elgg_view("input/text", array(
		"name" => "name",
		"id" => "name",
		"required" => "required",
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

	if ( $shortname == 'briefdescription' ){				// Brief description with character limit, count
		$label .= elgg_echo('groups:brief:charcount') . "0/" . $briefmaxlength;	// additional text for max length
		$input = elgg_view("input/{$valtype}", array(
			'name' => $shortname,
			'id' => $shortname,
			'value' => elgg_extract($shortname, $vars),
			'maxlength' => $briefmaxlength,
			'onkeyup' => "document.getElementById('briefdescr-lbl').innerHTML = '" . elgg_echo("groups:{$shortname}") . elgg_echo('groups:brief:charcount') . " ' + this.value.length + '/" . $briefmaxlength . "';"
		));
	}
	else
		$input = elgg_view("input/{$valtype}", array(
			"name" => $shortname,
            'id' => $shortname,
			"value" => elgg_extract($shortname, $vars),
		));

	//var_dump($shortname);

	if ( $shortname == 'briefdescription' )			// Brief description with character limit, count
		echo "<div class='mrgn-tp-md'><label id='briefdescr-lbl' for='$shortname'>{$label}</label>{$line_break}{$input}</div>";
	else
		echo "<div class='mrgn-tp-md'><label for='$shortname'>{$label}</label>{$line_break}{$input}</div>";
}
?>
</div>