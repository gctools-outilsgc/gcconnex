<?php

/**
 * Group edit form
 *
 * This view contains the group profile field configuration
 *
 * @package ElggGroups
 */

$name = elgg_extract("name", $vars);
$name2 = elgg_extract("name2", $vars);
$description = elgg_extract("description", $vars);
$group_profile_fields = elgg_get_config("group");
$group = elgg_extract("entity", $vars);

// decode json into English / French parts
$json_title = json_decode($name);
$json_desc = json_decode($description);

if ( $json_title ){
  $name2 = $json_title->fr;
  $name = $json_title->en;
}

if ( $json_desc ){
  $description2 = $json_desc->fr;
  $description = $json_desc->en;
}

$btn_language =  '<ul class="nav nav-tabs nav-tabs-language">
  <li id="btnen"><a href="#" id="btnClicken">'.elgg_echo('lang:english').'</a></li>
  <li id="btnfr"><a href="#" id="btnClickfr">'.elgg_echo('lang:french').'</a></li>
</ul>';

echo $btn_language;

?>
<div class="tab-content tab-content-border">
<!-- title en -->
<div class="en">
    <label for="name_autocomplete">
        <?php echo elgg_echo("groups:name"); ?>
    </label>
    <br />
    <div id="suggestedText"></div>
    <?php
        //if creating a group
    if(empty($group)){
        echo elgg_view("input/groups_autocomplete", array(
                'id' => 'name',
				'name' => 'name',
				'value' => elgg_extract('name', $vars),
                'type' => 'en',
		));
    } else {
    ?>

	<?php echo elgg_view("input/text", array(
		"name" => "name",
		"value" => $name,
        'id' => 'name',
        'required '=> "required",
        'class' => 'ui-autocomplete-input',
	));
    }?>
</div>

<!-- title fr -->
<div class="fr">
    <label for="name2_autocomplete2">
        <?php echo elgg_echo("groups:name2"); ?>
    </label>
    <br />
    <div id="suggestedText2"></div>
    <?php
      //if creating a group
    if(empty($group)){
        echo elgg_view("input/groups_autocomplete", array(
                'id' => 'name2',
                'name' => 'name',
                'value' => elgg_extract('name', $vars),
                'type' => 'fr',
        ));
    } else {
    ?>

    <?php echo elgg_view("input/text", array(
        "name" => "name2",
        "value" => $name2,
        'id' => 'name2',
        'required '=> "required",
        'class' => 'ui-autocomplete-input',
    ));
    }?>
</div>

<div>
<label for="icon"><?php echo elgg_echo("groups:icon"); ?></label><br />
	<?php echo elgg_view("input/file", array("name" => "icon", 'id' => 'icon')); ?>
</div>

<div>
    <label for="c_photo">
        <?php echo elgg_echo('wet:cover_photo_input'); ?>
    </label>
    <div class="timeStamp"><?php echo elgg_echo('wet:cover_photo_dim');?></div>

    <?php echo elgg_view("input/file", array("name" => "c_photo", 'id' => 'c_photo')); ?>
    <?php echo elgg_view('input/checkbox', array('name'=>'remove_photo', 'label'=> elgg_echo('wet:cover_photo_remove'), 'value'=>'remove_c_photo',));?>
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

    if ($shortname == 'description'){
        $input_desc_en = elgg_view("input/{$valtype}", array(
            "name" => $shortname,
            'id' => $shortname,
            "value" => $description,
        ));
    }
    if ($shortname == 'description2'){
        $input_desc_fr = elgg_view("input/{$valtype}", array(
            "name" => $shortname,
            'id' => $shortname,
            "value" => $description2,
        ));
    }
	else
		$input = elgg_view("input/{$valtype}", array(
			"name" => $shortname,
            'id' => $shortname,
			"value" => $shortname,
		));

	if( $shortname == 'description2' )
         echo "<div class='fr'><label id='briefdescr-lbl' for='{$shortname}'>{$label}</label>{$line_break}{$input_desc_fr}</div>"; 
    elseif ( $shortname == 'description' )
         echo "<div class='en'><label id='briefdescr-lbl' for='{$shortname}'>{$label}</label>{$line_break}{$input_desc_en}</div>";
    else
        echo "<div><label for='{$shortname}'>{$label}</label>{$line_break}{$input}</div>";
}
echo'</div>';
if(get_current_language() == 'fr'){
?>
    <script>
        jQuery('.fr').show();
        jQuery('.en').hide();
        jQuery('#btnfr').addClass('active');

    </script>
<?php
}else{
?>
    <script>
        jQuery('.en').show();
        jQuery('.fr').hide();
        jQuery('#btnen').addClass('active');
    </script>
<?php
}
?>
<script>
jQuery(function(){

    var selector = '.nav li';

    $(selector).on('click', function(){
    $(selector).removeClass('active');
    $(this).addClass('active');
});

        jQuery('#btnClickfr').click(function(){
               jQuery('.fr').show();
               jQuery('.en').hide();
        });

          jQuery('#btnClicken').click(function(){
               jQuery('.en').show();
               jQuery('.fr').hide();
        });
});
</script>
