<?php
/**
 * Group profile fields
 
 2015/10/13-
 modified to only show long description for about tab
 */

$group = $vars['entity'];
$lang = get_current_language();
$profile_fields = elgg_get_config('group');

if (is_array($profile_fields) && count($profile_fields) > 0) {

	$even_odd = 'odd';
	foreach ($profile_fields as $key => $valtype) {
		// do not show the name
		if ($key == 'name') {
			continue;
		}

		$value = $group->$key;
		if (is_null($value)) {
			continue;
		}

		$options = array('value' => $group->$key);
		if ($valtype == 'tags') {
			$options['tag_names'] = $key;
		}

	$description = gc_explode_translation($group->description,$lang);

        if($key == 'description'){

				// identify available content
$description_json = json_decode($group->description);
$title_json = json_decode($group->name);

if( $description_json->en && $description_json->fr ){
	echo'<div id="change_language" class="change_language">';
	if (get_current_language() == 'fr'){

		?>			
		<span id="indicator_language_en" onclick="change_en('.group-desc', '.group-title');"><span id="fr_title" class="testClass hidden" ><?php echo $title_json->fr;?></span><span id="en_title" class="testClass hidden" ><?php echo $title_json->en;?></span><span id="en_content" class="testClass hidden" ><?php echo $description_json->en;?></span><span id="fr_content" class="testClass hidden" ><?php echo $description_json->fr;?></span><?php echo elgg_echo('box:indicator:en') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:en') ?></span></span>
			
		<?php
	}else{
		?>		
			
		<span id="indicator_language_fr" onclick="change_fr('.group-desc','.group-title');"><span id="fr_title" class="testClass hidden" ><?php echo $title_json->fr;?></span><span id="en_title" class="testClass hidden" ><?php echo $title_json->en;?></span><span id="en_content" class="testClass hidden" ><?php echo $description_json->en;?></span><span id="fr_content" class="testClass hidden" ><?php echo $description_json->fr;?></span><?php echo elgg_echo('box:indicator:fr') ?><span class="fake-link" id="fake-link-1"><?php echo elgg_echo('indicator:click:fr') ?></span></span>
		<?php	
	}
	echo'</div>';
}

            echo "<div class=\"{$even_odd} panel panel-custom\">";
                echo '<div class="panel-heading clearfix">';
                    echo '<h2 class="panel-title profile-info-head pull-left clearfix">Description</h2>';
                echo "</div>";
                echo '<div class="panel-body group-desc">';
           		echo $description;
                echo "</div>";
            echo "</div>";
            }

		$even_odd = ($even_odd == 'even') ? 'odd' : 'even';
	}
}
