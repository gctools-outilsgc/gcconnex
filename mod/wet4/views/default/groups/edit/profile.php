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
$group = elgg_extract("entity", $vars);

/*
$DBprefix=$CONFIG->dbprefix;

//$group = get_data('Select guid, name from '.$DBprefix.'groups_entity');
try{
    $connection = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
    $result = mysqli_query($connection, 'Select guid, name from '.$DBprefix.'groups_entity');
    $site_url = elgg_get_site_url();

    if(intval($result->num_rows)>0){
        echo '<script> $(document).ready(function () {';
        echo 'var source = [';
        while ($arr = $result->fetch_assoc()){
            // echo "Key: $key; Value: $value<br />\n";
            echo '{value:"'.$site_url.'/groups/profile/'.$arr['guid'].'/'. str_replace(' ','-',trim(strtolower($arr['name']))).'",';
            echo 'label:"'.trim($arr['name']).'"},';
        }
        echo '];';

        echo "$('#name').autocomplete({source: source,select: function (event, ui) { window.location.href = ui.item.value;}});});</script>";
    }
    $connection->close();
}
catch (Exception $e)
{
        $errMess=$e->getMessage();
        $errStack=$e->getTraceAsString();
        $errType=$e->getCode();
        gc_err_logging($errMess,$errStack,'Suggested Friends',$errType);
         $connection->close();
}*/


?>

<div>
    <label for="name">
        <?php echo elgg_echo("groups:name"); ?>
    </label>
    <br />
    <div id="suggestedText"></div>
    <?php
        //if creating a group
    if(empty($group)){
        echo elgg_view("input/groups_autocomplete", array(
				'name' => 'name',
				'value' => elgg_extract('name', $vars),
		));
    } else {
    ?>

	<?php echo elgg_view("input/text", array(
		"name" => "name",
		"value" => $name,
        'id' => 'name',
        'class' => 'ui-autocomplete-input',
	));
    }?>
</div>
<div>
<label for="icon"><?php echo elgg_echo("groups:icon"); ?></label><br />
	<?php echo elgg_view("input/file", array("name" => "icon", 'id' => 'icon')); ?>
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

	if ( $shortname == 'briefdescription' )			// Brief description with character limit, count
        echo "<div><label id='briefdescr-lbl' for='{$shortname}'>{$label}</label>{$line_break}{$input}</div>";
	else
        echo "<div><label for='{$shortname}'>{$label}</label>{$line_break}{$input}</div>";
}